<?php
namespace App\Modules\Core;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Food;
use App\Models\Order;
use App\Models\Restaurant;
use App\Services\FCMService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class Helper
{

    public static function restaurant_data_formatting($data, $multi_data = false)
    {

        $storage = [];
        if ($multi_data == true) {
            foreach ($data as $item) {

                /* if(isset($item->fav)&&($item->fav!="" ||$item->fav!= null)){
                     $data['fav']=1;
                 }else{

                     $data['fav']=0;
                 }*/

                if ($item->opening_time) {
                    $item['available_time_starts'] = $item->opening_time->format('H:i');
                    unset($item['opening_time']);
                }
                if ($item->closeing_time) {
                    $item['available_time_ends'] = $item->closeing_time->format('H:i') ?? "00:00:00";
                    unset($item['closeing_time']);
                }

                $ratings = Helper::calculate_restaurant_rating($item['rating']);

                unset($item['rating']);
                $item['avg_rating'] = $ratings['rating'] ?? 0;
                $item['rating_count'] = $ratings['total'] ?? 0;
                if (isset($item['distance']))
                    $item['distance_time'] = ceil(($item['distance'] / 80) * 60);
                array_push($storage, $item);
            }
            $data = $storage;
        } else {
            if ($data->opening_time) {
                $data['available_time_starts'] = $data->opening_time->format('H:i');
                unset($data['opening_time']);
            }
            if ($data->closeing_time) {
                $data['available_time_ends'] = $data->closeing_time->format('H:i');
                unset($data['closeing_time']);
            }
            $ratings = Helper::calculate_restaurant_rating($data['rating']);
            unset($data['rating']);
            $data['avg_rating'] = $ratings['rating'];
            $data['rating_count'] = $ratings['total'];
            if (isset($data->distance))
                $data['distance_time'] = ceil(($data->distance / 80) * 60);


        }


        return $data;
    }

    public static function calculate_restaurant_rating($ratings)
    {
        $total_submit = $ratings[0] + $ratings[1] + $ratings[2] + $ratings[3] + $ratings[4];
        //  print_r($total_submit); exit;
        $rating = ($ratings[0] * 5 + $ratings[1] * 4 + $ratings[2] * 3 + $ratings[3] * 2 + $ratings[4]) / ($total_submit ? $total_submit : 1);
        return ['rating' => $rating, 'total' => $total_submit];
    }

    public static function update_restaurant_rating($ratings, $product_rating)
    {
        $restaurant_ratings = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
        if ($ratings) {
            $restaurant_ratings[1] = $ratings[4];
            $restaurant_ratings[2] = $ratings[3];
            $restaurant_ratings[3] = $ratings[2];
            $restaurant_ratings[4] = $ratings[1];
            $restaurant_ratings[5] = $ratings[0];
            $restaurant_ratings[$product_rating] = $ratings[5 - $product_rating] + 1;
        } else {
            $restaurant_ratings[$product_rating] = 1;
        }
        return json_encode($restaurant_ratings);
    }

    public static function food_data_formatting($data, $multi_data = false, $trans = false, $local = 'en')
    {
        $storage = [];
        if ($multi_data == true) {
            foreach ($data as $item) {
                $variations = [];
                if ($item->title) {
                    $item['name'] = $item->title;
                    unset($item['title']);
                }
                if ($item->start_time) {
                    $item['available_time_starts'] = $item->start_time->format('H:i');
                    unset($item['start_time']);
                }
                if ($item->end_time) {
                    $item['available_time_ends'] = $item->end_time->format('H:i');
                    unset($item['end_time']);
                }

                if ($item->start_date) {
                    $item['available_date_starts'] = $item->start_date->format('Y-m-d');
                    unset($item['start_date']);
                }
                if ($item->end_date) {
                    $item['available_date_ends'] = $item->end_date->format('Y-m-d');
                    unset($item['end_date']);
                }
                $categories = [];
                foreach (json_decode($item['category_ids']) as $value) {
                    $categories[] = ['id' => (string)$value->id, 'position' => $value->position];
                }
                $item['category_ids'] = $categories;
                $item['attributes'] = json_decode($item['attributes']);
                $item['choice_options'] = json_decode($item['choice_options']);
                // $item['add_ons'] = self::addon_data_formatting(AddOn::withoutGlobalScope('translate')->whereIn('id', json_decode($item['add_ons']))->active()->get(), true, $trans, $local);
                /* foreach (json_decode($item['variations'], true) as $var) {
                     array_push($variations, [
                         'type' => $var['type'],
                         'price' => (float)$var['price']
                     ]);
                 }
                 $item['variations'] = $variations;*/
                $item['restaurant_name'] = $item->restaurant->name;
                $item['restaurant_discount'] = self::get_restaurant_discount($item->restaurant) ? $item->restaurant->discount->discount : 0;
                $item['restaurant_opening_time'] = $item->restaurant->opening_time ? $item->restaurant->opening_time->format('H:i') : null;
                $item['restaurant_closing_time'] = $item->restaurant->closeing_time ? $item->restaurant->closeing_time->format('H:i') : null;
                $item['schedule_order'] = $item->restaurant->schedule_order;
                $item['tax'] = $item->restaurant->tax;
                $item['rating_count'] = (int)($item->rating ? array_sum(json_decode($item->rating, true)) : 0);
                $item['avg_rating'] = (float)($item->avg_rating ? $item->avg_rating : 0);

                if ($trans) {
                    $item['translations'][] = [
                        'translationable_type' => 'App\Models\Food',
                        'translationable_id' => $item->id,
                        'locale' => 'en',
                        'key' => 'name',
                        'value' => $item->name
                    ];

                    $item['translations'][] = [
                        'translationable_type' => 'App\Models\Food',
                        'translationable_id' => $item->id,
                        'locale' => 'en',
                        'key' => 'description',
                        'value' => $item->description
                    ];
                }

                if (count($item['translations']) > 0) {
                    foreach ($item['translations'] as $translation) {
                        if ($translation['locale'] == $local) {
                            if ($translation['key'] == 'name') {
                                $item['name'] = $translation['value'];
                            }

                            if ($translation['key'] == 'title') {
                                $item['name'] = $translation['value'];
                            }

                            if ($translation['key'] == 'description') {
                                $item['description'] = $translation['value'];
                            }
                        }
                    }
                }
                if (!$trans) {
                    unset($item['translations']);
                }

                unset($item['restaurant']);
                unset($item['rating']);
                array_push($storage, $item);
            }
            $data = $storage;
        } else {
            $variations = [];
            $categories = [];
            foreach (json_decode($data['category_ids']) as $value) {
                $categories[] = ['id' => (string)$value->id, 'position' => $value->position];
            }
            $data['category_ids'] = $categories;
            // $data['category_ids'] = json_decode($data['category_ids']);
            $data['attributes'] = json_decode($data['attributes']);
            $data['choice_options'] = json_decode($data['choice_options']);
            //$data['add_ons'] = self::addon_data_formatting(AddOn::whereIn('id', json_decode($data['add_ons']))->active()->get(), true, $trans, $local);
            if($data['variations']!="") {
                foreach (json_decode($data['variations'], true) as $var) {
                    array_push($variations, [
                        'type' => $var['type'],
                        'price' => (float)$var['price']
                    ]);

                }
            }
            if ($data->title) {
                $data['name'] = $data->title;
                unset($data['title']);
            }
            if ($data->start_time) {
                $data['available_time_starts'] = $data->start_time->format('H:i');
                unset($data['start_time']);
            }
            if ($data->end_time) {
                $data['available_time_ends'] = $data->end_time->format('H:i');
                unset($data['end_time']);
            }
            if ($data->start_date) {
                $data['available_date_starts'] = $data->start_date->format('Y-m-d');
                unset($data['start_date']);
            }
            if ($data->end_date) {
                $data['available_date_ends'] = $data->end_date->format('Y-m-d');
                unset($data['end_date']);
            }
            $data['variations'] = $variations;
            $data['restaurant_name'] = $data->restaurant->name;
           // $data['restaurant_discount'] = self::get_restaurant_discount($data->restaurant) ? $data->restaurant->discount->discount : 0;
            $data['restaurant_opening_time'] = $data->restaurant->opening_time ? $data->restaurant->opening_time->format('H:i') : null;
            $data['restaurant_closing_time'] = $data->restaurant->closeing_time ? $data->restaurant->closeing_time->format('H:i') : null;
            $data['schedule_order'] = $data->restaurant->schedule_order;
            $data['rating_count'] = (int)($data->rating ? array_sum(json_decode($data->rating, true)) : 0);
            $data['avg_rating'] = (float)($data->avg_rating ? $data->avg_rating : 0);

            if ($trans) {
                $data['translations'][] = [
                    'translationable_type' => 'App\Models\Food',
                    'translationable_id' => $data->id,
                    'locale' => 'en',
                    'key' => 'name',
                    'value' => $data->name
                ];

                $data['translations'][] = [
                    'translationable_type' => 'App\Models\Food',
                    'translationable_id' => $data->id,
                    'locale' => 'en',
                    'key' => 'description',
                    'value' => $data->description
                ];
            }

           /* if (count($data['translations']) > 0) {
                foreach ($data['translations'] as $translation) {
                    if ($translation['locale'] == $local) {
                        if ($translation['key'] == 'name') {
                            $data['name'] = $translation['value'];
                        }

                        if ($translation['key'] == 'title') {
                            $item['name'] = $translation['value'];
                        }

                        if ($translation['key'] == 'description') {
                            $data['description'] = $translation['value'];
                        }
                    }
                }
            }
            if (!$trans) {
                unset($data['translations']);
            }

            unset($data['restaurant']);
            unset($data['rating']);*/
        }

        return $data;
    }

    public static function get_discount($coupon, $order_amount)
    {
        $discount_ammount = 0;
        if ($coupon->discount_type == 'percentage' && $coupon->discount > 0) {
            $discount_ammount = $order_amount * ($coupon->discount / 100);
         
        } else {
            $discount_ammount = $coupon->discount;
        }
        if ($coupon->max_discount > 0) {
            $discount_ammount = $discount_ammount > $coupon->max_discount ? $coupon->max_discount : $discount_ammount;
        }
        return $discount_ammount;
    }


    // copoun check
    public static function is_valide($coupon, $user_id, $restaurant_id, $cart_items = [])
    {
              //echo $coupon; exit;
        $start_date = Carbon::parse($coupon->start_date);
        $expire_date = Carbon::parse($coupon->expire_date);

        $today = Carbon::now();
        if ($start_date->format('Y-m-d') > $today->format('Y-m-d') || $expire_date->format('Y-m-d') < $today->format('Y-m-d')) {
            return 407;  //coupon expire
        }

        /* if($coupon->coupon_type == 'restaurant_wise' && !in_array($restaurant_id, json_decode($coupon->data, true)))
         {
             return 404;
         }
         else if($coupon->coupon_type == 'zone_wise')
         {
             if(json_decode($coupon->data, true)){
                 $data = Restaurant::whereIn('zone_id',json_decode($coupon->data, true))->where('id', $restaurant_id)->first();
                 if(!$data)
                 {
                     return 404;
                 }
             }
             else
             {
                 return 404;
             }
         }*/
        if ($coupon->coupon_type == 'first_order') {


            $total = Order::where(['user_id' => $user_id])->count();
            if ($total < 1) {
                return 200;
            } else {
                return 406;//Limite error
            }
        }
        if ($coupon != null) {
            $product_price = 0;
            //  $cart_items=$cart_items;
            // print_r($cart_items); exit;
            if(!empty($cart_items)){
            foreach ($cart_items as $key => $value) {
                if(!isset($value['food_id'])) $food_id=$key; else $food_id=$value['food_id'];
                $food = food::where('id', $food_id)->first();
                if (empty($food)) {
                    return 400;
                }
                $product_price += $food ['price'] * $value['quantity'];
            }

            if ($coupon) {

                // $coupon1=Coupon::active()->where(['code' => $coupon])->get();


                if (isset($coupon['min_purchase'])) {

                    if ($product_price < $coupon['min_purchase']) {
                        /*return response()->json([
                            'status' => false,
                            'errors' => __('min_purchase to apply coupon is ') . $coupon['min_purchase'],
                            'message' => __('min_purchase to apply coupon is ') . $coupon['min_purchase'],
                            'data' => [],
                            'code' => 407
                        ], HTTPResponseCodes::Sucess['code']);*/
                        return __('min_purchase to apply coupon is ') . $coupon['min_purchase'];
                        //   return (array('status'=>false,'msg'=> ));
                    }

                }
                return 200;
            }
            }

        } else {
            $total = Order::where(['user_id' => $user_id, 'coupon_code' => $coupon['code']])->count();
            if ($total < $coupon['limit']) {
                return 200;
            } else {
                return 406;//Limite orer
            }
        }
        return 404; //not found
    }

    public static function product_data_formatting($data, $multi_data = false, $trans = false, $local = 'en')
    {
        $storage = [];
        if ($multi_data == true) {
            foreach ($data as $item) {
                $variations = [];
                if ($item->title) {
                    $item['name'] = $item->title ?? "";
                    unset($item['title']);
                }
                if ($item->start_time) {
                    $item['available_time_starts'] = $item->start_time->format('H:i');
                    unset($item['start_time']);
                }
                if ($item->end_time) {
                    $item['available_time_ends'] = $item->end_time->format('H:i');
                    unset($item['end_time']);
                }

                if ($item->start_date) {
                    $item['available_date_starts'] = $item->start_date->format('Y-m-d');
                    unset($item['start_date']);
                }
                if ($item->end_date) {
                    $item['available_date_ends'] = $item->end_date->format('Y-m-d');
                    unset($item['end_date']);
                }
                $categories = [];
                foreach (json_decode($item['category_ids']) as $value) {
                    $categories[] = ['id' => (string)$value->id, 'position' => $value->position];
                }
                $item['category_ids'] = $categories;
                $item['attributes'] = json_decode($item['attributes']);
                $item['choice_options'] = json_decode($item['choice_options']);
                foreach (json_decode($item['variations'], true) as $var) {
                    array_push($variations, [
                        'type' => $var['type'],
                        'price' => (float)$var['price']
                    ]);
                }
                $item['variations'] = $variations;
                $item['restaurant_name'] = $item->restaurant->name;
                $item['restaurant_opening_time'] = $item->restaurant->opening_time ? $item->restaurant->opening_time->format('H:i') : null;
                $item['restaurant_closing_time'] = $item->restaurant->closeing_time ? $item->restaurant->closeing_time->format('H:i') : null;
                $item['schedule_order'] = $item->restaurant->schedule_order;
                $item['rating_count'] = (int)($item->rating ? array_sum(json_decode($item->rating, true)) : 0);
                $item['avg_rating'] = (float)($item->avg_rating ? $item->avg_rating : 0);


                unset($item['restaurant']);
                unset($item['rating']);
                array_push($storage, $item);
            }
            $data = $storage;
        } else {
            $variations = [];
            $categories = [];
            foreach (json_decode($data['category_ids']) as $value) {
                $categories[] = ['id' => (string)$value->id, 'position' => $value->position];
            }
            $data['category_ids'] = $categories;
            // $data['category_ids'] = json_decode($data['category_ids']);
            $data['attributes'] = json_decode($data['attributes']);
            $data['choice_options'] = json_decode($data['choice_options']);
            foreach (json_decode($data['variations'], true) as $var) {
                array_push($variations, [
                    'type' => $var['type'],
                    'price' => (float)$var['price']
                ]);
            }
            if ($data->title) {
                $data['name'] = $data->title;
                unset($data['title']);
            }
            if ($data->start_time) {
                $data['available_time_starts'] = $data->start_time->format('H:i');
                unset($data['start_time']);
            }
            if ($data->end_time) {
                $data['available_time_ends'] = $data->end_time->format('H:i');
                unset($data['end_time']);
            }
            if ($data->start_date) {
                $data['available_date_starts'] = $data->start_date->format('Y-m-d');
                unset($data['start_date']);
            }
            if ($data->end_date) {
                $data['available_date_ends'] = $data->end_date->format('Y-m-d');
                unset($data['end_date']);
            }
            $data['variations'] = $variations;
            $data['restaurant_name'] = $data->restaurant->name;
            $data['restaurant_opening_time'] = $data->restaurant->opening_time ? $data->restaurant->opening_time->format('H:i') : null;
            $data['restaurant_closing_time'] = $data->restaurant->closeing_time ? $data->restaurant->closeing_time->format('H:i') : null;
            $data['schedule_order'] = $data->restaurant->schedule_order;
            $data['rating_count'] = (int)($data->rating ? array_sum(json_decode($data->rating, true)) : 0);
            $data['avg_rating'] = (float)($data->avg_rating ? $data->avg_rating : 0);

            unset($data['restaurant']);
            unset($data['rating']);
        }

        return $data;
    }

    public static function get_restaurant_id()
    {
        if (auth('vendor_employee')->check()) {
            return auth('vendor_employee')->user()->restaurant->id;
        }
        // echo(auth('vendor')->user()->restaurants[0]->id); exit;
        return auth('vendor')->user()->restaurants[0]->id;
    }

    public static function get_vendor_id()
    {
        if (auth('vendor')->check()) {
            return auth('vendor')->id();
        } else if (auth('vendor_employee')->check()) {
            return auth('vendor_employee')->user()->vendor_id;
        }
        return 0;
    }

    public static function get_vendor_data()
    {
        if (auth('vendor')->check()) {
            return auth('vendor')->user();
        } else if (auth('vendor_employee')->check()) {
            return auth('vendor_employee')->user()->vendor;
        }
        return 0;
    }

    public static function module_permission_check($module_name)
    {
        /*  if (!auth('admin')->user()->role) {
              return false;
          }*/


        $permission = auth('admin')->user()->role->modules;
        if (isset($permission) && in_array($module_name, (array)json_decode($permission)) == true) {
            return true;
        }
        if (auth('admin')->user()->role_id == 1) {
            return true;
        }
        return false;
    }

    public static function format_coordiantes($coordinates)
    {
        // print_r($coordinates); exit;
        $data = [];
        foreach ($coordinates as $coord) {
            $data[] = (object)['lat' => $coord->getlat(), 'lng' => $coord->getlng()];
        }
        return $data;
    }


    public static function product_discount_calculate($product, $price, $restaurant_discount)
    {
        //  $restaurant_discount = self::get_restaurant_discount($restaurant);
        if (isset($restaurant_discount)) {
            $price_discount = ($price / 100) * $restaurant_discount['discount'];
        } else if ($product['discount_type'] == 'percentage') {
            $price_discount = ($price / 100) * $product['discount'];
        } else {
            $price_discount = $product['discount'];
        }
        return $price_discount;
    }

    public static function send_order_notification($order)
    {

        try {

            $status = $order->order_status;
            $value = __($status);
            if ($value) {
                $data = [
                    'title' => __('order status'),
                    'description' => $value,
                    'order_id' => $order->id,
                    'image' => '',
                    'type' => 'order_status',
                ];
                FCMService::send_push_notif_to_device($order->customer->cm_firebase_token, $data);
                DB::table('user_notifications')->insert([
                    'data' => json_encode($data),
                    'user_id' => $order->user_id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            if (!$order->scheduled && (($order->order_type == 'take_away' && $order->order_status == 'pending') || ($order->payment_method != 'cash_on_delivery' && $order->order_status == 'confirmed'))) {
                $data = [
                    'title' => trans('order_push_title'),
                    'description' => trans('new_order_push_description'),
                    'order_id' => $order->id,
                    'image' => '',
                    'type' => 'new_order',
                ];
                FCMService::send_push_notif_to_device($order->restaurant->vendor->firebase_token, $data);
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
    public static function getCartCount()
    {
        if (Auth::check()) {
            // For logged-in users, get count from the database
            return Cart::where('user_id', Auth::id())->sum('quantity');
        } else {
            // For guest users, get count from the session
            return session()->has('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0;
        }
    }

    public static function combinations($arrays)
    {
        $result = [[]];
        foreach ($arrays as $property => $property_values) {
            $tmp = [];
            foreach ($result as $result_item) {
                foreach ($property_values as $property_value) {
                    $tmp[] = array_merge($result_item, [$property => $property_value]);
                }
            }
            $result = $tmp;
        }
        return $result;
    }
}
