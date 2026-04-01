<?php

namespace App\Http\Controllers\Api\V1;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Conversation;
//use App\Models\DeliveryMan;
use App\Models\UserInfo;
use App\Models\Message;
use App\Models\Order;
use App\Models\Vendor;
use App\Models\User;
use App\Services\FCMService;
use App\Traits\UploadAttachTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ConversationController extends Controller
{
    use UploadAttachTrait;
    public function messages_store(Request $request)
    {
        info(['New message request',$request->all()]);
        if ($request->has('image')) {
            $image_name=[];
            $img=$request->image;

            $image_name = $this->Upload($img,'conversation' );
               // array_push($image_name,$name);

        } else {
            $image_name = null;
        }

        $limit = $request['limit']??10;
        $offset = $request['offset']??1;

        $sender = UserInfo::where('user_id', $request->user()->id)->first();
        if(!$sender){
            $sender = new UserInfo();
            $sender->user_id = $request->user()->id;
            $sender->f_name = $request->user()->f_name;
            $sender->l_name = $request->user()->l_name;
            $sender->phone = $request->user()->phone;
            $sender->email = $request->user()->email;
            $sender->image = $request->user()->image;
            $sender->save();
        }

        if($request->conversation_id){
            $conversation = Conversation::find($request->conversation_id);

            if($conversation->sender_id == $sender->id){
                $receiver_id = $conversation->receiver_id;
                $receiver = UserInfo::find($receiver_id);
                if($receiver->vendor_id) {
                    $vendor = Vendor::find($receiver->vendor_id);
                    $fcm_token = $vendor->firebase_token;
                }elseif($receiver->admin_id){
                    $receiver_id = 0;
                }
            }else{
                $receiver_id =$conversation->sender_id;
                $receiver = UserInfo::find($receiver_id);
                if($receiver->vendor_id){
                    $vendor = Vendor::find($receiver->vendor_id);
                    $fcm_token=$vendor->firebase_token;
                }elseif($receiver->admin_id){
                    $receiver_id = 0;
                }
            }
        }else{
            if($request->receiver_type == 'admin'){
                $receiver_id = 0;
            }else if($request->receiver_type == 'vendor'){
                $receiver = UserInfo::where('vendor_id',$request->receiver_id)->first();
                $vendor = Vendor::find($request->receiver_id);
                if(!$receiver){
                    $receiver = new UserInfo();
                    $receiver->vendor_id = $vendor->id;
                    $receiver->f_name = $vendor->restaurants[0]->name;
                    $receiver->l_name = '';
                    $receiver->phone = $vendor->phone;
                    $receiver->email = $vendor->email;
                    $receiver->image = $vendor->restaurants[0]->logo;
                    $receiver->save();
                }

                $receiver_id = $receiver->id;
                $fcm_token=$vendor->firebase_token;

            }

            $conversation = Conversation::WhereConversation($sender->id,$receiver_id)->first();
        }

        if(!$conversation){
            $conversation = new Conversation;
            $conversation->sender_id = $sender->id;
            $conversation->sender_type = 'customer';
            $conversation->receiver_id = $receiver_id;
            $conversation->receiver_type = $request->receiver_type;
            $conversation->unread_message_count = 0;
            $conversation->last_message_time = Carbon::now()->toDateTimeString();
            $conversation->save();
            $conversation= Conversation::find($conversation->id);
        }

        $message = new Message();
        $message->conversation_id = $conversation->id;
        $message->sender_id = $sender->id;
        $message->message = $request->message;
        $message->file = $image_name?json_encode($image_name, JSON_UNESCAPED_SLASHES):null;
        try {
            if($message->save())
            $conversation->unread_message_count = $conversation->unread_message_count? $conversation->unread_message_count+1:1;
            $conversation->last_message_id=$message->id;
            $conversation->last_message_time = Carbon::now()->toDateTimeString();
            $conversation->save();
            {
                if($request->receiver_type == 'admin' || $receiver_id == 0){
                    $data = [
                        'title' =>__('message'),
                        'description' =>__('message_description'),
                        'order_id' => '',
                        'image' => '',
                        'message' => json_encode($message) ,
                        'type'=> 'message'
                    ];
                    FCMService::send_push_notif_to_topic($data,'admin_message','message');
                }else if($request->receiver_type == 'vendor' || $request->receiver_type == 'delivery_man'){
                    $data = [
                        'title' =>trans('message'),
                        'description' =>trans('message_description'),
                        'order_id' => '',
                        'image' => '',
                        'message' => json_encode($message) ,
                        'type'=> 'message',
                        'conversation_id'=> $conversation->id,
                        'sender_type'=> 'user'
                    ];
                    FCMService::send_push_notif_to_device($fcm_token, $data);

                }
            }

        } catch (\Exception $e) {
            info($e);
        }

        $messages = Message::where(['conversation_id' => $conversation->id])->latest()->paginate($limit, ['*'], 'page', $offset);

        $conv = Conversation::with('sender','receiver','last_message')->find($conversation->id);

        if($conv->sender_type == 'vendor' && $conversation->sender){
            $vd = Vendor::find($conv->sender->vendor_id);
            $order = Order::where('user_id',$request->user()->id)->where('restaurant_id', $vd->restaurants[0]->id)->whereIn('order_status', ['pending','accepted','confirmed','processing','handover','picked_up'])->count();
        }else if($conv->receiver_type == 'vendor' && $conversation->receiver){
            $vd = Vendor::find($conv->receiver->vendor_id);
            $order = Order::where('user_id',$request->user()->id)->where('restaurant_id', $vd->restaurants[0]->id)->whereIn('order_status', ['pending','accepted','confirmed','processing','handover','picked_up'])->count();
        }
        else{
            $order=1;
        }


        $data =  [
            'total_size' => intval($messages->total()),
            'limit' => intval($limit),
            'offset' => intval($offset),
            'status' => ($order>0)?true:false,
            'message' => 'successfully sent!',
            'messages' => $messages->items(),
            'conversation' => $conv,
        ];
        return response()->json($data, 200);
    }

    public function chat_image(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        if ($request->has('image')) {
            $image_name = Helpers::upload('conversation/', 'png', $request->file('image'));
        } else {
            $image_name = 'def.png';
        }

        $url = asset('storage/app/public/conversation') . '/' . $image_name;

        return response()->json(['image_url' => $url], 200);
    }


    public function conversations(Request $request)
    {
        $limit = $request['limit']??10;
        $offset = $request['offset']??1;

        $sender = UserInfo::where('user_id', $request->user()->id)->first();
        if(!$sender){
            $sender = new UserInfo();
            $sender->user_id = $request->user()->id;
            $sender->f_name = $request->user()->f_name;
            $sender->l_name = $request->user()->l_name;
            $sender->phone = $request->user()->phone;
            $sender->email = $request->user()->email;
            $sender->image = $request->user()->image;
            $sender->save();
        }
if($request->receiver_type=="vendor"){
    $conversations = Conversation::with('sender','receiver','last_message')->where(['sender_id' => $sender->id,'receiver_id'=>$request->vendor_id])->orWhere(['receiver_id' => $sender->id,'sender_id'=>$request->vendor_id])->where('receiver_type',$request->receiver_type)->orderBy('last_message_time', 'DESC')->paginate($limit, ['*'], 'page', $offset);

}else{
    $conversations = Conversation::with('sender','receiver','last_message')->where(['sender_id' => $sender->id])->orWhere(['receiver_id' => $sender->id])->orderBy('last_message_time', 'DESC')->paginate($limit, ['*'], 'page', $offset);
}

        $data =  [
            'total_size' => intval($conversations->total()),
            'limit' => intval($limit),
            'offset' => intval($offset),
            'conversations' => $conversations->items()
        ];
        return response()->json($data, 200);
    }


    public function messages(Request $request)
    {
        $limit = $request['limit']??10;
        $offset = $request['offset']??1;

        $user = UserInfo::where('user_id', $request->user()->id)->first();
        if(!$user){
            $user = new UserInfo();
            $user->user_id = $request->user()->id;
            $user->f_name = $request->user()->f_name;
            $user->l_name = $request->user()->l_name;
            $user->phone = $request->user()->phone;
            $user->email = $request->user()->email;
            $user->image = $request->user()->image;
            $user->save();
        }

        $conversation = null;
        if($request->conversation_id){
            $conversation = Conversation::with(['sender','receiver','last_message'])->find($request->conversation_id);
        }else if($request->has('admin_id')){
            $conversation = Conversation::with(['sender','receiver','last_message'])->WhereConversation($user->id,0)->first();
            $order=0;
        }else if($request->vendor_id){
            $vendor = UserInfo::where('vendor_id', $request->vendor_id)->first();
            if(!$vendor){
                $vd = Vendor::find($request->vendor_id);
                $vendor = new UserInfo();
                $vendor->vendor_id = $vd->id;
                $vendor->f_name = $vd->restaurants[0]->name;
                $vendor->l_name = '';
                $vendor->phone = $vd->phone;
                $vendor->email = $vd->email;
                $vendor->image = $vd->restaurants[0]->logo;
                $vendor->save();
            }
            $conversation = Conversation::with(['sender','receiver','last_message'])->WhereConversation($user->id,$vendor->id)->first();
        }/*else if($request->delivery_man_id){
            $dm = UserInfo::where('deliveryman_id', $request->delivery_man_id)->first();
            if(!$dm){
                $user2 = DeliveryMan::find($request->delivery_man_id);
                $dm = new UserInfo();
                $dm->deliveryman_id = $user2->id;
                $dm->f_name = $user2->f_name;
                $dm->l_name = $user2->l_name;
                $dm->phone = $user2->phone;
                $dm->email = $user2->email;
                $dm->image = $user2->image;
                $dm->save();
            }
            $conversation = Conversation::with(['sender','receiver','last_message'])->WhereConversation($user->id,$dm->id)->first();
        }*/

        if(isset($conversation)){
            if($conversation->sender_type == 'vendor' && $conversation->sender){
                $vd = Vendor::find($conversation->sender->vendor_id);
                $order = Order::where('user_id',$user->user_id)->where('restaurant_id', $vd->restaurants[0]->id)->whereIn('order_status', ['pending','accepted','confirmed','processing','handover','picked_up'])->count();
            }else if($conversation->receiver_type == 'vendor' && $conversation->receiver){
                $vd = Vendor::find($conversation->receiver->vendor_id);
                $order = Order::where('user_id',$user->user_id)->where('restaurant_id', $vd->restaurants[0]->id)->whereIn('order_status', ['pending','accepted','confirmed','processing','handover','picked_up'])->count();
            }/*else if($conversation->sender_type == 'delivery_man' && $conversation->sender){
                $user2 = DeliveryMan::find($conversation->sender->deliveryman_id);
                $order = Order::where('user_id',$user->user_id)->where('delivery_man_id', $user2->id)->whereIn('order_status', ['pending','accepted','confirmed','processing','handover','picked_up'])->count();
            }else if($conversation->receiver_type == 'delivery_man' && $conversation->receiver){
                $user2 = DeliveryMan::find($conversation->receiver->deliveryman_id);
                $order = Order::where('user_id',$user->user_id)->where('delivery_man_id', $user2->id)->whereIn('order_status', ['pending','accepted','confirmed','processing','handover','picked_up'])->count();
            }*/
            else{
                $order=1;
            }

            $lastmessage = $conversation->last_message;
            if($lastmessage && $lastmessage->sender_id != $user->id ) {
                $conversation->unread_message_count = 0;
                $conversation->save();
            }
            Message::where(['conversation_id' => $conversation->id])->where('sender_id','!=',$user->id)->update(['is_seen' => 1]);
            $messages = Message::where(['conversation_id' => $conversation->id])->latest()->paginate($limit, ['*'], 'page', $offset);
        }else{
            $messages =[];
            $order=0;
        }


        $data =  [
            'total_size' => $messages? intval($messages->total()):0,
            'limit' => intval($limit),
            'offset' => intval($offset),
            'status' => ($order > 0)?true:false,
            'messages' => $messages? $messages->items():[],
            'conversation' => $conversation
        ];
        return response()->json($data, 200);
    }






}
