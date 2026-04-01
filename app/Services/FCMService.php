<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FCMService
{
    public static function send($token, $notification)
    {
        Http::acceptJson()->withToken(config('fcm.token'))->post(
            'https://fcm.googleapis.com/fcm/send',
            [
                'to' => $token,
                'notification' => $notification,
            ]
        );
    }
    public static function send_push_notif_to_topic($data, $topic, $type)
    {
        $key =config('fcm.token');

        $url = "https://fcm.googleapis.com/fcm/send";
        $header = array(
            "authorization: key=" . $key . "",
            "content-type: application/json"
        );

        if(isset($data['message'])){
            $message = $data['message'];
        }else{
            $message = '';
        }

        if (isset($data['order_id'])) {
            $postdata = '{
                "to" : "/topics/' . $topic . '",
                "mutable_content": true,
                "data" : {
                    "title":"' . $data['title'] . '",
                    "body" : "' . $data['description'] . '",
                    "image" : "' . $data['image'] . '",
                    "order_id":"' . $data['order_id'] . '",
                    "is_read": 0,
                    "type":"' . $type . '"
                },
                "notification" : {
                    "title":"' . $data['title'] . '",
                    "body" : "' . $data['description'] . '",
                    "image" : "' . $data['image'] . '",
                    "order_id":"' . $data['order_id'] . '",
                    "title_loc_key":"' . $data['order_id'] . '",
                    "body_loc_key":"' . $type . '",
                    "type":"' . $type . '",
                    "is_read": 0,
                    "icon" : "new",
                    "sound": "notification.wav",
                    "android_channel_id": "bastaat"
                  }
            }';
        } else {
            $postdata = '{
                "to" : "/topics/' . $topic . '",
                "mutable_content": true,
                "data" : {
                    "title":"' . $data['title'] . '",
                    "body" : "' . $data['description'] . '",
                    "image" : "' . $data['image'] . '",
                    "is_read": 0,
                    "type":"' . $type . '",
                },
                "notification" : {
                    "title":"' . $data['title'] . '",
                    "body" : "' . $data['description'] . '",
                    "image" : "' . $data['image'] . '",
                    "body_loc_key":"' . $type . '",
                    "type":"' . $type . '",
                    "is_read": 0,
                    "icon" : "new",
                    "sound": "notification.wav",
                    "android_channel_id": "bastaat"
                  }
            }';
        }

        $ch = curl_init();
        $timeout = 120;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        // Get URL content
        $result = curl_exec($ch);
        // close handle to release resources
        curl_close($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        // FCM response
       // dd($result);
       // return $result;
    }
    public static function send_push_notif_to_device($fcm_token, $data)
    {
        $key =config('fcm.token');
        $url = "https://fcm.googleapis.com/fcm/send";
        $header = array(
            "authorization: key=" . $key . "",
            "content-type: application/json"
        );

        if(isset($data['message'])){
            $message = $data['message'];
        }else{
            $message = '';
        }
        if(isset($data['conversation_id'])){
            $conversation_id = $data['conversation_id'];
        }else{
            $conversation_id = '';
        }
        if(isset($data['sender_type'])){
            $sender_type = $data['sender_type'];
        }else{
            $sender_type = '';
        }

        $postdata = '{
            "to" : "' . $fcm_token . '",
            "mutable_content": true,
            "data" : {
                "title":"' . $data['title'] . '",
                "body" : "' . $data['description'] . '",
                "image" : "' . $data['image'] . '",
                "order_id":"' . $data['order_id'] . '",
                "type":"' . $data['type'] . '",
                "conversation_id":"' . $conversation_id . '",
                "sender_type":"' . $sender_type . '",
                "is_read": 0
            },
            "notification" : {
                "title" :"' . $data['title'] . '",
                "body" : "' . $data['description'] . '",
                "image" : "' . $data['image'] . '",
                "order_id":"' . $data['order_id'] . '",
                "title_loc_key":"' . $data['order_id'] . '",
                "body_loc_key":"' . $data['type'] . '",
                "type":"' . $data['type'] . '",
                "is_read": 0,
                "icon" : "new",
                "sound": "notification.wav",
                "android_channel_id": "bastaat"
            }
        }';

        $ch = curl_init();
        $timeout = 120;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        // Get URL content
        $result = curl_exec($ch);
        // close handle to release resources
        curl_close($ch);

        return $result;
    }
    
        public static function send_order_notification($order)
    {

        try {
            $status = ($order->order_status == 'delivered') ? __('delivery_boy_will_delivered' ): $order->order_status;
            $value = self::order_status_update_message($status);
            if ($value) {
                $data = [
                    'title' =>__('order_push_title'),
                    'description' => $value,
                    'order_id' => $order->id,
                    'image' => '',
                    'type' => 'order_status',
                ];
                self::send_push_notif_to_device($order->customer->cm_firebase_token, $data);
                DB::table('user_notifications')->insert([
                    'data' => json_encode($data),
                    'user_id' => $order->user_id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            if ($status == 'picked_up') {
                $data = [
                    'title' => __('order_push_title'),
                    'description' => $value,
                    'order_id' => $order->id,
                    'image' => '',
                    'type' => 'order_status',
                ];
                self::send_push_notif_to_device($order->restaurant->vendor->firebase_token, $data);
                DB::table('user_notifications')->insert([
                    'data' => json_encode($data),
                    'vendor_id' => $order->restaurant->vendor_id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            if ($order->order_type == 'delivery' && $order->order_status == 'pending' && $order->payment_method == 'cash_on_delivery' && $order->order_type != 'take_away') {

                    $data = [
                        'title' => __('order_push_title'),
                        'description' => __('new_order_push_description'),
                        'order_id' => $order->id,
                        'image' => '',
                        'type' => 'new_order',
                    ];
                    self::send_push_notif_to_device($order->restaurant->vendor->firebase_token, $data);
                    DB::table('user_notifications')->insert([
                        'data' => json_encode($data),
                        'vendor_id' => $order->restaurant->vendor_id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

            }

            if ($order->order_type == 'delivery' && !$order->scheduled && $order->order_status == 'pending' && $order->payment_method == 'cash_on_delivery' && config('order_confirmation_model') == 'restaurant') {
                $data = [
                    'title' => trans('messages.order_push_title'),
                    'description' => trans('messages.new_order_push_description'),
                    'order_id' => $order->id,
                    'image' => '',
                    'type' => 'new_order',
                ];
                self::send_push_notif_to_device($order->restaurant->vendor->firebase_token, $data);
                DB::table('user_notifications')->insert([
                    'data' => json_encode($data),
                    'vendor_id' => $order->restaurant->vendor_id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            if (!$order->scheduled && (($order->order_type == 'take_away' && $order->order_status == 'pending') || ($order->payment_method != 'cash_on_delivery' && $order->order_status == 'confirmed'))) {
                $data = [
                    'title' => __('order_push_title'),
                    'description' => __('new_order_push_description'),
                    'order_id' => $order->id,
                    'image' => '',
                    'type' => 'new_order',
                ];
                self::send_push_notif_to_device($order->restaurant->vendor->firebase_token, $data);
                DB::table('user_notifications')->insert([
                    'data' => json_encode($data),
                    'vendor_id' => $order->restaurant->vendor_id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            if ($order->order_status == 'confirmed' && $order->order_type != 'take_away'&& $order->payment_method == 'cash_on_delivery') {

                    $data = [
                        'title' => __('order_push_title'),
                        'description' => __('new_order_push_description'),
                        'order_id' => $order->id,
                        'image' => '',
                        'type' => 'new_order',
                    ];
                    self::send_push_notif_to_device($order->restaurant->vendor->firebase_token, $data);
                    DB::table('user_notifications')->insert([
                        'data' => json_encode($data),
                        'vendor_id' => $order->restaurant->vendor_id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

            }

            return true;
        } catch (\Exception $e) {
            info($e);
        }
        return false;
    }
    
     public static function order_status_update_message($status)
    {
        if ($status == 'pending') {
            $data = __( 'order_pending_message');
        } elseif ($status == 'confirmed') {
            $data =__( 'order_confirmation_msg');
        } elseif ($status == 'processing') {
            $data =__( 'order_processing_message');
        } elseif ($status == 'picked_up') {
            $data =__( 'out_for_delivery_message');
        } elseif ($status == 'handover') {
            $data =__( 'order_handover_message');
        } elseif ($status == 'delivered') {
            $data =__('order_delivered_message');
        } elseif ($status == 'delivery_boy_delivered') {
            $data = __( 'delivery_boy_delivered_message');
        } elseif ($status == 'accepted') {
            $data = __( 'delivery_boy_assign_message');
        } elseif ($status == 'canceled') {
            $data = __( 'order_cancled_message');
        } elseif ($status == 'refunded') {
            $data =__( 'order_refunded_message');
        } else {
            $data = '{"status":"0","message":""}';
        }

        $res = json_decode($data, true);

        if ($res['status'] == 0) {
            return 0;
        }
        return $res['message'];
    }
}
