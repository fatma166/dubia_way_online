<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\UserNotification;
use App\Modules\Core\HTTPResponseCodes;
use Illuminate\Http\Request;
use App\CentralLogics\Helpers;

class NotificationController extends Controller
{
    public function get_notifications(Request $request){
       $offset=$request->offset??0;
       $limit=$request->limit??10;

      //  $zone_id= json_decode($request->header('zoneId'), true);
        try {
            $notifications = Notification::active()->where('target', 'customer')/*->where(function($q)use($zone_id){
                $q->whereNull('zone_id')->orWhereIn('zone_id', $zone_id);
            })*/->where('created_at', '>=', \Carbon\Carbon::today()->subDays(15))->orWhere('updated_at', '>=', \Carbon\Carbon::today()->subDays(15))->orderBy('created_at','desc')->paginate($limit, ['*'], 'page', $offset);
            $notifications->append('data');

            $user_notifications = UserNotification::where('user_id', $request->user()->id)->where('created_at', '>=', \Carbon\Carbon::today()->subDays(15))->orderBy('created_at','desc')->paginate($limit, ['*'], 'page', $offset);
            $notifications =  $notifications->merge($user_notifications);
            return response()->json([
                'status' => HTTPResponseCodes::Sucess['status'],
                'message'=>HTTPResponseCodes::Sucess['message'],
                'errors' => [],
                'data' => $notifications,
                'code'=>HTTPResponseCodes::Sucess['code']
            ],HTTPResponseCodes::Sucess['code']);
        } catch (\Exception $e) {
            //info(['Notification api issue_____',$e->getMessage()]);
            return response()->json([
                'status' =>false,
                'errors'=>__('error when retrieve data'),
                'message' =>HTTPResponseCodes::BadRequest['message'],
                'code'=>HTTPResponseCodes::BadRequest['code']
            ],HTTPResponseCodes::Sucess['code']);

        }
    }

}
