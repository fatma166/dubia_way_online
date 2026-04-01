<?php

namespace App\Repositories\Api;


use App\Http\Resources\Api\AddressResource;
use App\Http\Resources\Api\GetOrderResource;
use App\Http\Resources\Api\ListOrderResource;
use App\Http\Resources\Api\TrackOrderResource;
use App\Interfaces\Api\OrderInterface;
use App\Libarary\CustomerPayLogic;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\CustomerAddress;
use App\Models\Food;
use App\Models\Offer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Restaurant;
use App\Modules\Core\Helper;
use App\Modules\Core\HTTPResponseCodes;
use App\Services\FCMService;
use http\Env\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\OrderItem;

class OrderRepository implements OrderInterface
{

   public  function calcualate_order_amount($request){
        $product_price=0;
        $offer_discount_amount=0;
       // $cart_items=$request['cart_items'];
       // $cart_items=json_decode(html_entity_decode($request['cart_items']));

        if(!Auth::check()){
            $decodedCartItems=html_entity_decode($request['cart_items']);

            $decodedCartItems = str_replace('"{', '{', $decodedCartItems);
            $decodedCartItems = str_replace('}"', '}', $decodedCartItems);
            $cart_items = json_decode($decodedCartItems, true);
        }else{
            $cart_items=json_decode(html_entity_decode($request['cart_items']));
        }
        
        foreach ($cart_items as $key => $value) {
            if(isset($value->id)) $product_id_=$value->id; else $product_id_=$value['id'];
            if(isset($value->quantity)) $product_quantity_=$value->quantity; else $product_quantity_=$value['quantity'];
            if(isset($value->price)) $product_price_=$value->price; else $product_price_=$value['price'];
            $product_data= Food::where('id',$product_id_)->first();
			$price_after=$product_price_;
                                                                           if ($product_data['discount_type'] == "percent") {
                                                                               $price_after -= ($product_price_* $product_data['discount'] / 100);
                                                                           } else {
                                                                               $price_after -= $product_data['discount'];
                                                                           }
            $product_price +=  $price_after* $product_quantity_;
            
        }
	   $restaurant=Restaurant::find(config('app.default_vendor'));
	   $tax = 0;//$restaurant->tax;
        $total_tax_amount= ($tax > 0)?(($total_price * $tax)/100):0;
	   // offers code
	   // Check for active offers
    $activeOffer = Offer::where('is_active', 1)->first();

 
/*if ($activeOffer && $activeOffer->type == 'buy_two_get_one_free'&&(count($cart_items)>2)) {
        // Logic for Buy Two Get One Free
        $totalItems = array_sum(array_column($cart_items, 'quantity'));
        if ($totalItems >= 3) {
            // Gather prices of all products in the cart
            $prices = [];
            foreach ($cart_items as $item) {
                
				if(isset($item->id)) $product_id_=$item->id; else $product_id_=$item['id'];
            if(isset($item->quantity)) $product_quantity_=$item->quantity; else $product_quantity_=$item['quantity'];
            if(isset($item->price)) $product_price_=$item->price; else $product_price_=$item['price'];
				 $product_data= Food::where('id',$product_id_)->first();
			$price_after=$product_price_;
                                                                           if ($product_data['discount_type'] == "percent") {
                                                                               $price_after -= ($product_price_* $product_data['discount'] / 100);
                                                                           } else {
                                                                               $price_after -= $product_data['discount'];
                                                                           }
           // $product_price +=  $price_after* $product_quantity_;
				$prices[] = $price_after;
            }

            // Sort prices to find the lowest
            sort($prices);
            $lowest_price = $prices[0]; // The lowest price

            // Apply discount for one free item
            $freeItems = floor($totalItems / 3);
            $product_price -= ($lowest_price * $freeItems);
            $offer_discount_amount=($lowest_price * $freeItems);
        }
		$shipping_coast=0;
		$order_amount = round($product_price+ $total_tax_amount + $shipping_coast,2 );
			 $data=['status'=>'true','order_amount'=>$order_amount,'total_price'=>$product_price,'coupon_discount_amount'=>0,'tax'=>$tax,'shipping_coast'=>$restaurant->delivery_charge,'product_price'=>$product_price,'offer_discount_amount'=>$offer_discount_amount];

        return($data);
        // No coupon code can be applied when an offer is active
       // return ['status' => 'true', 'order_amount' => round($product_price, 2)];
    }*/
  //////////
  /* if ($activeOffer && $activeOffer->type == 'buy_two_get_one_free' && count($cart_items) > 2) {

    $eligibleUnitPrices = [];  // Prices of items matching the offer category
    $nonEligibleTotal = 0;     // Sum of non-matching items
    $total_tax_amount = 0;     // You can set this according to your tax logic
    $offer_discount_amount = 0;

    foreach ($cart_items as $item) {

        $product_id = isset($item->id) ? $item->id : $item['id'];
        $quantity = isset($item->quantity) ? $item->quantity : $item['quantity'];
        $price = isset($item->price) ? $item->price : $item['price'];

        $product_data = Food::where('id', $product_id)->first();
        if (!$product_data) continue;

        $price_after = $price;

        // Apply product discount
        if ($product_data->discount_type == "percent") {
            $price_after -= ($price * $product_data->discount / 100);
        } else {
            $price_after -= $product_data->discount;
        }

        // Check if this product belongs to the offer category
        $isEligible = true;
        if ($activeOffer->category_id && $product_data->category_id != $activeOffer->category_id) {
            $isEligible = false;
        }

        // Collect prices accordingly
        for ($i = 0; $i < $quantity; $i++) {
            if ($isEligible) {
                $eligibleUnitPrices[] = $price_after;
            } else {
                $nonEligibleTotal += $price_after;
            }
        }
    }

    // Apply offer to eligible products
    $eligibleCount = count($eligibleUnitPrices);
    $product_price = 0;

    if ($eligibleCount >= 3) {
        sort($eligibleUnitPrices);
        $freeItems = floor($eligibleCount / 3);
        $offer_discount_amount = array_sum(array_slice($eligibleUnitPrices, 0, $freeItems));
        $product_price = array_sum($eligibleUnitPrices) - $offer_discount_amount;
    } else {
        $product_price = array_sum($eligibleUnitPrices);
    }

    // Add the price of non-eligible items
    $product_price += $nonEligibleTotal;

    // Final order amount
    $shipping_coast = 0; // Set if applicable
    $order_amount = round($product_price + $total_tax_amount + $shipping_coast, 2);

    $data = [
        'status' => 'true',
        'order_amount' => $order_amount,
        'total_price' => $product_price,
        'coupon_discount_amount' => 0,
        'tax' => $total_tax_amount,
        'shipping_coast' => $shipping_coast,
        'product_price' => $product_price,
        'offer_discount_amount' => $offer_discount_amount,
    ];

    return $data;

    // No coupon code can be applied when an offer is active
}

    
    // if offer buy one get one 
    
    if ($activeOffer && $activeOffer->type == 'buy_one_get_one_free' && (count($cart_items) > 1)) {
    $totalItems = array_sum(array_column($cart_items, 'quantity'));

    if ($totalItems >= 2) {
        $unit_prices = [];
        $product_price = 0;

        foreach ($cart_items as $item) {
            $product_id = $item->id ?? $item['id'];
            $quantity = $item->quantity ?? $item['quantity'];
            $base_price = $item->price ?? $item['price'];

            $product_data = Food::find($product_id);
            $price_after_discount = $base_price;

            if ($product_data) {
                if ($product_data->discount_type == 'percent') {
                    $price_after_discount -= ($base_price * $product_data->discount / 100);
                } else {
                    $price_after_discount -= $product_data->discount;
                }
            }

            // ????? ??? ?? ???? ????? ??? ????????
            for ($i = 0; $i < $quantity; $i++) {
                $unit_prices[] = $price_after_discount;
            }
        }

        // ???? ????? ???????? ?????? ??? ?????
        $product_price = array_sum($unit_prices);

        // ????? ??????? ?????? ??? ??????
        sort($unit_prices);

        // ??? ??? ??? ??? ????? (Buy One Get One)
        $freeItems = floor($totalItems / 2);
        $offer_discount_amount = array_sum(array_slice($unit_prices, 0, $freeItems));

        // ????? ??? ?????
        $product_price -= $offer_discount_amount;
    }

    $shipping_coast = 0;
    $order_amount = round($product_price + $total_tax_amount + $shipping_coast, 2);

    return [
        'status' => 'true',
        'order_amount' => $order_amount,
        'total_price' => $product_price,
        'coupon_discount_amount' => 0,
        'tax' => $tax,
        'shipping_coast' => $restaurant->delivery_charge,
        'product_price' => $product_price,
        'offer_discount_amount' => $offer_discount_amount ?? 0,
    ];
}*///////////////////////////////////
/****$total_tax_amount = 0; // Use your actual tax logic
$shipping_coast = 0;   // Set if applicable
$product_price = 0;
$offer_discount_amount = 0;

$eligible_B2G1F = [];     // For Buy 2 Get 1 Free
$eligible_B1G1F = [];     // For Buy 1 Get 1 Free
$nonEligible = [];        // Items not eligible for either offer

foreach ($cart_items as $item) {
    $product_id = $item->id ?? $item['id'];
    $quantity = $item->quantity ?? $item['quantity'];
    $price = $item->price ?? $item['price'];

    $product = Food::find($product_id);
    if (!$product) continue;

    // Apply individual discount
    $final_price = $price;
    if ($product->discount_type === 'percent') {
        $final_price -= ($price * $product->discount / 100);
    } else {
        $final_price -= $product->discount;
    }

    for ($i = 0; $i < $quantity; $i++) {
        // Classify into offer groups
        if ($activeOffer && $activeOffer->type === 'buy_two_get_one_free' && $activeOffer->category_id) {
            if ($product->category_id == $activeOffer->category_id) {
                $eligible_B2G1F[] = $final_price;
                continue;
            }
        }

        // Check if B1G1 offer is active and this item isn't in B2G1
        if ($activeOffer && $activeOffer->type === 'buy_one_get_one_free') {
            $eligible_B1G1F[] = $final_price;
            continue;
        }

        // Otherwise, it's non-eligible
        $nonEligible[] = $final_price;
    }
}

// --- Apply Buy Two Get One Free ---
if (count($eligible_B2G1F) >= 3) {
    sort($eligible_B2G1F);
    $free = floor(count($eligible_B2G1F) / 3);
    $offer_discount_amount += array_sum(array_slice($eligible_B2G1F, 0, $free));
    $product_price += array_sum($eligible_B2G1F) - $offer_discount_amount;
} else {
    $product_price += array_sum($eligible_B2G1F);
}

// --- Apply Buy One Get One Free ---
if (count($eligible_B1G1F) >= 2) {
    sort($eligible_B1G1F);
    $free = floor(count($eligible_B1G1F) / 2);
    $discount = array_sum(array_slice($eligible_B1G1F, 0, $free));
    $offer_discount_amount += $discount;
    $product_price += array_sum($eligible_B1G1F) - $discount;
} else {
    $product_price += array_sum($eligible_B1G1F);
}

// --- Add non-eligible items ---
$product_price += array_sum($nonEligible);

// Final total
$order_amount = round($product_price + $total_tax_amount + $shipping_coast, 2);

return [
    'status' => 'true',
    'order_amount' => $order_amount,
    'total_price' => $product_price,
    'coupon_discount_amount' => 0,
    'tax' => $total_tax_amount,
    'shipping_coast' => $restaurant->delivery_charge ?? 0,
    'product_price' => $product_price,
    'offer_discount_amount' => $offer_discount_amount,
];****/
$total_tax_amount = 0;
$shipping_coast = 0;
$product_price = 0;
$offer_discount_amount = 0;

$eligible_B2G1F = [];
$eligible_B1G1F = [];
$nonEligible = [];

// Make sure these are passed from controller:
$buyTwoOffer = $buyTwoOffer ?? null; // type: buy_two_get_one_free
$buyOneOffer = $buyOneOffer ?? null; // type: buy_one_get_one_free

foreach ($cart_items as $item) {
    $product_id = $item->id ?? $item['id'];
    $quantity = $item->quantity ?? $item['quantity'];
    $price = $item->price ?? $item['price'];

    $product = Food::find($product_id);
    if (!$product) continue;

    // Apply discount
    $final_price = $price;
    if ($product->discount_type === 'percent') {
        $final_price -= ($price * $product->discount / 100);
    } else {
        $final_price -= $product->discount;
    }

    for ($i = 0; $i < $quantity; $i++) {
        $matched = false;

        // Check Buy 2 Get 1
        if ($buyTwoOffer && $buyTwoOffer->category_id == $product->category_id) {
            $eligible_B2G1F[] = $final_price;
            $matched = true;
        }

        // Check Buy 1 Get 1
        if (!$matched && $buyOneOffer && $buyOneOffer->category_id == $product->category_id) {
            $eligible_B1G1F[] = $final_price;
            $matched = true;
        }

        // If not eligible for any
        if (!$matched) {
            $nonEligible[] = $final_price;
        }
    }
}

// --- Apply Buy 2 Get 1 ---
if (count($eligible_B2G1F) >= 3) {
    sort($eligible_B2G1F);
    $free = floor(count($eligible_B2G1F) / 3);
    $discount = array_sum(array_slice($eligible_B2G1F, 0, $free));
    $offer_discount_amount += $discount;
    $product_price += array_sum($eligible_B2G1F) - $discount;
} else {
    $product_price += array_sum($eligible_B2G1F);
}

// --- Apply Buy 1 Get 1 ---
if (count($eligible_B1G1F) >= 2) {
    sort($eligible_B1G1F);
    $free = floor(count($eligible_B1G1F) / 2);
    $discount = array_sum(array_slice($eligible_B1G1F, 0, $free));
    $offer_discount_amount += $discount;
    $product_price += array_sum($eligible_B1G1F) - $discount;
} else {
    $product_price += array_sum($eligible_B1G1F);
}

// Add non-eligible products
$product_price += array_sum($nonEligible);

// Final Total
$order_amount = round($product_price + $total_tax_amount + $shipping_coast, 2);

return [
    'status' => 'true',
    'order_amount' => $order_amount,
    'total_price' => $product_price,
    'coupon_discount_amount' => 0,
    'tax' => $total_tax_amount,
    'shipping_coast' => $restaurant->delivery_charge ?? 0,
    'product_price' => $product_price,
    'offer_discount_amount' => $offer_discount_amount,
];



//////////////////////////////////

    
/*if ($activeOffer && $activeOffer->type == 'buy_one_get_one_free' && (count($cart_items) > 1)) {
    // Logic for Buy One Get One Free
    $totalItems = array_sum(array_column($cart_items, 'quantity'));
    if ($totalItems >= 2) {
        // Gather prices of all individual units in the cart
        $unit_prices = [];
        $product_price = 0;

        foreach ($cart_items as $item) {
            $product_id_ = isset($item->id) ? $item->id : $item['id'];
            $product_quantity_ = isset($item->quantity) ? $item->quantity : $item['quantity'];
            $product_price_ = isset($item->price) ? $item->price : $item['price'];

            $product_data = Food::where('id', $product_id_)->first();
            $price_after = $product_price_;

            if ($product_data) {
                if ($product_data['discount_type'] == "percent") {
                    $price_after -= ($product_price_ * $product_data['discount'] / 100);
                } else {
                    $price_after -= $product_data['discount'];
                }
            }

            // Add total price
            $product_price += ($price_after * $product_quantity_);

            // Add each unit price separately for sorting
            for ($i = 0; $i < $product_quantity_; $i++) {
                $unit_prices[] = $price_after;
            }
        }

        // Sort to find the cheapest units for free
        sort($unit_prices);
        $freeItems = floor($totalItems / 2);
        $lowest_total_discount = array_sum(array_slice($unit_prices, 0, $freeItems));

        // Apply the total discount
        $product_price -= $lowest_total_discount;
       // echo $product_price; exit;
        $offer_discount_amount = $lowest_total_discount;
    }

    $shipping_coast = 0;
    $order_amount = round($product_price + $total_tax_amount + $shipping_coast, 2);

    $data = [
        'status' => 'true',
        'order_amount' => $order_amount,
        'total_price' => $product_price,
        'coupon_discount_amount' => 0,
        'tax' => $tax,
        'shipping_coast' => $restaurant->delivery_charge,
        'product_price' => $product_price,
        'offer_discount_amount' => $offer_discount_amount,
    ];

    return $data;
    // No coupon code can be applied when an offer is active
}*/


		//end of offer
	   
	   
	   
	   
	   
        if($request->has('coupon_code')) {
            $coupon = Coupon::active()->where(['code' => $request['coupon_code']])->first();
            if (isset($coupon['min_purchase'])) {
                if ($product_price < $coupon['min_purchase']) {
                  //  /*return response()->json([
//'status' => false,
                     //   'errors' => __('min_purchase to apply coupon is ') . $coupon['min_purchase'],
                      //  'message' => __('min_purchase to apply coupon is ') . $coupon['min_purchase'],
                      //  'data' => [],
  //                      'code' => 407
//], HTTPResponseCodes::Sucess['code']);/*/
                    return (array('status'=>false,'msg'=> __('min_purchase to apply coupon is ') . $coupon['min_purchase']));
                }

            }
        }
         //

        $coupon_discount_amount =isset( $coupon) ? Helper::get_discount($coupon, $product_price) : 0;

        $total_price = $product_price- $coupon_discount_amount ;
        
        if(isset($coupon['coupon_type'])&&($coupon['coupon_type']=='free_delivery')){
            $shipping_coast = 0;
        }else {
            $shipping_coast = $restaurant->delivery_charge;
        }
	   
	


        if(($restaurant['minimum_order']) > $product_price )
        {
            /* return response()->json([
               //  'status' =>false,
               //  'errors'=>__('not_found'),
               //  'message' =>__('you_need_to_order_at_least amount') ."  ".$restaurant->minimum_order,
               //  'data' => [],
                // 'code'=>408
             //],HTTPResponseCodes::Sucess['code']);*/
            return( array('status'=>false,'msg'=>__('you_need_to_order_at_least amount') ."  ".$restaurant->minimum_order));
        }

        if(isset($coupon))
        {
            $coupon->increment('total_uses');
        }
        $order_amount = round($total_price + $total_tax_amount + $shipping_coast,2 );//config('round_up_to_digit')
        $data=['status'=>'true','order_amount'=>$order_amount,'total_price'=>$total_price,'coupon_discount_amount'=>$coupon_discount_amount,'tax'=>$tax,'shipping_coast'=>$shipping_coast,'product_price'=>$product_price,'offer_discount_amount'=>0];

        return($data);


 }
    public function payment_success($data)
    {
        //   echo   Session::get('order_id'); exit;

        $order_id= $data['client_reference_id'];
        $order=Order::find($order_id);
        if(!$order){
            return false;
        }
        $order->order_status='confirmed';
        $order->payment_method='stripe';
        $order->transaction_reference=$data['payment_intent'];
        $order->payment_status='paid';
        $order->confirmed=now();
        $order->save();
        try {
            FCMService::send_order_notification($order);
        } catch (\Exception $e) {
            return false;

        }
        return true;
    }
    public function cart_order($request)
    {
       // print_r($request->all()); exit;
        /* if($request->has('reorder')){
         $past_order_id=$request->past_order_id;
         $order_data=Order::where('id',$past_order_id)->first();
         $past_coupon_title=$order_data['coupon_discount_title'];
         $request->cart_it=self::get_order_details($past_order_id);
         }*/

        //print_r($request->all());
        if(!Auth::check()){
            $decodedCartItems=html_entity_decode($request['cart_items']);

            $decodedCartItems = str_replace('"{', '{', $decodedCartItems);
            $decodedCartItems = str_replace('}"', '}', $decodedCartItems);
            $cart_items = json_decode($decodedCartItems, true);
        }else{
            $cart_items=json_decode(html_entity_decode($request['cart_items']));
        }




        foreach ($cart_items as $key => $value) {
          //  print_r($value['id']); exit;
           // $food = food::where('id', $value['food_id'])->first();
             if(isset($value->id)) $product_id=$value->id; else $product_id=$value['id'];
             if(isset($value->quantity)) $product_quantity=$value->id; else $product_quantity=$value['quantity'];

            $food = food::where('id',$product_id)->first();

            if($food['product_quantity']<$product_quantity){

                return response()->json([
                    'status' =>false,
                    'errors'=>__('order_stock_out'),
                    'message' =>__('one of order item out of stock'),
                    
                    'code'=>406
                ],HTTPResponseCodes::Sucess['code']);

            }

        }


        // TODO: Implement cart_order() method.

        $coupon = null;
        $free_delivery_by = null;
        $schedule_at = $request['schedule_at']?\Carbon\Carbon::parse($request['schedule_at']):now();
        if($request['schedule_at']&& $schedule_at < now())
        {
            return response()->json([
                'status' =>false,
                'errors'=>__('order_time'),
                'message' =>__('you_can_not_schedule_a_order_in_past'),
               // 'data' => [],
                'code'=>406
            ],HTTPResponseCodes::Sucess['code']);


        }


        $restaurant =config('app.default_vendor') ;//Restaurant::selectRaw('*, IF(((select count(*) from `restaurant_schedule` where `restaurants`.`id` = `restaurant_schedule`.`restaurant_id` and `restaurant_schedule`.`day` = '.$schedule_at->format('w').' and `restaurant_schedule`.`opening_time` < "'.$schedule_at->format('H:i:s').'" and `restaurant_schedule`.`closing_time` >"'.$schedule_at->format('H:i:s').'") > 0), true, false) as open')->where('id', $request->restaurant_id)->first();
        $restaurant = Restaurant::selectRaw('*, IF(((select count(*) from `restaurant_schedule` where `restaurants`.`id` = `restaurant_schedule`.`restaurant_id` and `restaurant_schedule`.`day` = '.$schedule_at->format('w').' and `restaurant_schedule`.`opening_time` < "'.$schedule_at->format('H:i:s').'" and `restaurant_schedule`.`closing_time` >"'.$schedule_at->format('H:i:s').'") > 0), true, false) as open')->where('id', config('app.default_vendor'))->first();
        if(!$restaurant)
        {
            return response()->json([
                'status' =>false,
                'errors'=>__('restaurant_not_found'),
                'message' =>HTTPResponseCodes::BadRequest['message'],
               // 'data' => [],
               'code'=>HTTPResponseCodes::BadRequest['code']
            ],HTTPResponseCodes::Sucess['code']);

        }
        /* if($restaurant->open == false)
         {
             echo "kjkj"; exit;
             return response()->json([
                 'status' =>HTTPResponseCodes::InvalidArguments['status'],
                 'message' => trans('messages.restaurant_is_closed_at_order_time'),
                 'errors' => [],

                 'code'=>HTTPResponseCodes::InvalidArguments['code']
             ],HTTPResponseCodes::InvalidArguments['code']);
   
         }*/

        


        if($request['order_type'] == 'take_away')
        {
            $shipping_coast=0;
        }
        else if(isset($coupon->coupon_type)&&($coupon->coupon_type == 'free_delivery'))
        {
            $shipping_coast = 0;
            $coupon = null;
            $free_delivery_by = 'admin';
        }else{
            $shipping_coast=$restaurant->delivery_charge;
        }
        if(isset($request['address']))
        {
            if(Auth::check()) {
                $user_id = Auth::guard('web')->user()->id;

                $address_data = $request['address'];
                $address_data['user_id'] = $user_id;//array('user_id'=>$user_id,'contact_person_number'=>'ahmed','address'=>'tiyleklj','contact_person_name'=>'contact_person_name','floor'=>'floor','road','house'=>'house');
            }else{
                $address_data = $request['address'];
                $address_data['user_id'] = null;
            }

            $order_address= new CustomerAddress();
            $order_address->fill((array)$address_data);
            $order_address->save();
            //   $order_address=CustomerAddress::insert();
            $order_address=$order_address['id'];


        } else
        {
            $order_address=$request->address_id;
        }
        $coupon_discount_amount=0;

        /* $coupon_discount_amount = $coupon ? CouponLogic::get_discount($coupon, $product_price + $total_addon_price - $restaurant_discount_amount) : 0;
         $total_price = $product_price + $total_addon_price - $restaurant_discount_amount - $coupon_discount_amount ;

         $tax = $restaurant->tax;
         $total_tax_amount= ($tax > 0)?(($total_price * $tax)/100):0;

         if($restaurant->minimum_order > $product_price + $total_addon_price )
         {
             return response()->json([
                 'errors' => [
                     ['code' => 'order_time', 'message' => trans('messages.you_need_to_order_at_least', ['amount'=>$restaurant->minimum_order.' '.Helpers::currency_code()])]
                 ]
             ], 406);
         }*/
 //echo "Ddskjksd"; exit;
     // DB::beginTransaction();
     //   try {
            $order = new Order();
            if(Auth::check()) {
                $order->user_id =  Auth::guard('web')->user()->id;
            }else{
                $order->user_id =null;
            }
            $order->coupon_discount_amount = $coupon_discount_amount;
            if (isset($request['address'])) {
                $order->delivery_address_id = $order_address;
            } else {
                $order->delivery_address_id = $order_address;
            }
            $order->order_note = $request->order_note;
            $order->restaurant_id = config('app.default_vendor');
            $order->delivery_charge = $shipping_coast;
            $order->payment_method ="cash_on_delivery"; //$request->payment_method;
            $order->payment_status = $request['payment_method']=='wallet'?'paid':'unpaid';
            $order->order_status = $request['payment_method']=='digital_payment'?'failed':($request->payment_method == 'wallet'?'confirmed':'pending');
            $order->pending = now();
            $order->confirmed = $request->payment_method == 'wallet' ? now() : null;
            $order->created_at = now();
            $order->updated_at = now();



            //cart_items= (array) $request->cart_items;//array('food_id' => 1, 'quantity' => 2, 'price' => 80));
            $product_price=0;
           // $cart_items=json_decode(html_entity_decode($request['cart_items']));

            $data_cal=self::calcualate_order_amount($request);

            /* foreach ($cart_items as $key => $value) {
                 $product_price +=  $value['price']* $value['quantity'];
             }
             $coupon_discount_amount = $coupon ? Helper::get_discount($coupon, $product_price) : 0;
             $total_price = $product_price- $coupon_discount_amount ;
             $tax = $restaurant->tax;
             $total_tax_amount= ($tax > 0)?(($total_price * $tax)/100):0;
              */
            $coupon_discount_amount=$data_cal['coupon_discount_amount'];

            $product_price=$data_cal['product_price'];
            $tax=$data_cal['tax'];
            $total_price = $product_price- $coupon_discount_amount ;
            $total_tax_amount= ($tax > 0)?(($total_price * $tax)/100):0;
            if($restaurant->minimum_order > $product_price )
            {
                return response()->json([
                    'status' =>false,
                    'errors'=>__('not_found'),
                    'message' =>__('you_need_to_order_at_least amount') ."  ".$restaurant->minimum_order,
                    'data' => [],
                    'code'=>408
                ],HTTPResponseCodes::Sucess['code']);
            }
            if($coupon)
            {
                $coupon->increment('total_uses');
            }
            $order_amount = $data_cal['order_amount'];//round($total_price + $total_tax_amount + $shipping_coast,2 );//config('round_up_to_digit')

            if($request->payment_method == 'wallet' && $request->user()->wallet_balance < $order_amount)
            {


                return response()->json([
                    'status' =>false,
                    'errors'=>__('insufficient_balance'),
                    'message' =>__('insufficient_balance'),
                    'data' => [],
                    'code'=>409
                ],HTTPResponseCodes::Sucess['code']);
            }

            foreach ($cart_items as $key => $value) {
                if(isset($value->id)) $product_id_=$value->id; else $product_id_=$value['id'];
                if(isset($value->quantity)) $product_quantity_=$value->quantity; else $product_quantity_=$value['quantity'];
                if(isset($value->price)) $product_price_=$value->price; else $product_price_=$value['price'];
                $food = food::where('id', $product_id_)->first();

                if($food['product_quantity']<$product_quantity_){

                    return response()->json([
                        'status' =>false,
                        'errors'=>__('order_stock_out'),
                        'message' =>__('one of order item out of stock'),
                        'data' => [],
                        'code'=>406
                    ],HTTPResponseCodes::Sucess['code']);

                }
                // Retrieve the product
                $product = Food::find($product_id_);

                if ($product) {
                    // Get the current quantity
                    $currentQuantity = $product->product_quantity;

                    // Decrease the quantity by $value['quantity']
                    $newQuantity = $currentQuantity - $product_quantity_;
                    if($newQuantity>=0) {
                        // Update the product's quantity
                        $product->product_quantity = $newQuantity;
                        $product->save();
                    }else{
                        // Update the product's quantity
                        $product->product_quantity = 0;
                        $product->	in_stock = 0;
                        $product->save();
                        return response()->json([
                            'status' =>false,
                            'errors'=>__('order_stock_out1'),
                            'message' =>__('one of order item out of stock'),
                            'data' => [],
                            'code'=>406
                        ],HTTPResponseCodes::Sucess['code']);

                    }
                    // return $newQuantity;
                }


            }


           // try {
                $order->coupon_discount_amount = round($coupon_discount_amount, 2);//config('round_up_to_digit')
                $order->offer_discount_amount=round($data_cal['offer_discount_amount'], 2);
                $order->coupon_discount_title = $coupon ? $coupon->title : '';
                // $order->free_delivery_by = $free_delivery_by;
                // $order->restaurant_discount_amount= round($restaurant_discount_amount, config('round_up_to_digit'));
                $order->total_tax_amount = round($total_tax_amount, 2);//config('round_up_to_digit')
                $order->order_amount = $order_amount;
                $order->save();

                $last_order = $order->id;

                Session::put('order_id', $last_order);

                foreach ($cart_items as $key => $value) {
                    if(isset($value->id)) $product_id=$value->id; else $product_id=$value['id'];
                    if(isset($value->quantity)) $product_quantity=$value->quantity; else $product_quantity=$value['quantity'];
                    if(isset($value->price)) $product_price=$value->price; else $product_price=$value['price'];
                    if(isset($value->variations)) $product_variations=$value->variations; else $product_variations=$value['variations'];

                    $food = food::where('id', $product_id)->first();
					$discount_on_food=0; 
					if ($food['discount_type'] == "percent") {
						$discount_on_food= ($product_price* $food['discount'] / 100);
					} else {
						$discount_on_food= $food['discount'];
					}

					
                    $order_item = new OrderDetail();
                    $order_item->food_id = $food['id'];
                    $order_item->food_details = json_encode($food);
                    $order_item->quantity = $product_quantity;
                    $order_item->price = $product_price;
                    $order_item->variation =json_encode($product_variations);
                    $order_item->order_id = $last_order;
					$order_item->discount_on_food=$discount_on_food;	
                    $order_item->save();
                }
           //     DB::commit();
                //Helper::send_order_notification($order);
                //$restaurant->increment('total_order');
                if ($request->payment_method == 'wallet') CustomerPayLogic::create_wallet_transaction($order->user_id, $order->order_amount, 'order_place', $order->id);

                try {
                    if ($order->order_status == 'pending') {
                        //  Mail::to($customer['email'])->send(new \App\Mail\OrderPlaced($order->id));
                    }
                } catch (\Exception $ex) {
                    info($ex);
                }
                if(!Auth::check()){
                session()->forget('cart');
                }else{
                    Cart::where('user_id',Auth::guard('web')->user()->id)->delete();
                }
                return response()->json([
                    'status' =>HTTPResponseCodes::Sucess['status'],
                    'errors'=>[],
                    'message' =>__('order_placed_successfully'),
                    'data' => ['order_id'=>$order->id,'total_amount'=>$order_amount,'order_address'=>$order_address],
                    'code'=>200
                ],HTTPResponseCodes::Sucess['code']);


          /*  } catch (\Exception $e) {
                info($e);
                return response()->json([$e], 403);
            }*/
            return response()->json([
                'status' =>false,
                'errors'=>[],
                'message' =>__('failed_to_place_order'),
                'data' => ['order_id'=>$order->id,'total_amount'=>$order_amount],
                'code'=>403
            ],HTTPResponseCodes::Sucess['code']);
            // return true;

      /* } catch (\Exception $e) {
            DB::rollback();
            return false;
            //  return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            // something went wrong
        }*/
    }

// Method to clear the cart
    public function clear_cart($user_id)
    {
        if ($user_id) {
            // Logic for clearing the cart for authenticated users
            // For example, you might clear the user's cart in the database
            Cart::where('user_id', $user_id)->delete();
        } else {
            // Logic for clearing the cart for guests
            // For example, you might clear session cart items
            Session::forget('cart');
        }
    }
    public function get_pervious_address($request)
    {
        // TODO: Implement get_pervious_address() method.

        // return

        $offset=$request->offset??0;
        $limit=$request->limit??3;
      /*  if(Auth::guard('api')) {
            exit;
            $user_id = Auth::guard('api')->user()->id;
        }else{*/
           // echo "kjj"; exit;
            $user_id = Auth::guard('web')->user()->id;
        //}

        $adds= CustomerAddress::where('user_id',$user_id)->orderby('id','desc')->paginate($limit, ['*'], 'page', $offset);
        return AddressResource::collection($adds);
    }
    public function get_address($user_id,$address_id)
    {
        // TODO: Implement get_pervious_address() method.

        // return
        $adds= CustomerAddress::where(['user_id'=>$user_id,'id'=>$address_id])->get()->first();

        return  new AddressResource($adds);
    }
    public function track_order($order_id,$user_id)
    {
       
        // TODO: Implement track_order() method.
       // DB::enableQueryLog();
        $order=Order::with(['restaurant','customer_address'])->withCount('details')->where(['id' => $order_id, 'user_id' => $user_id])->first();

     //$query= DB::getQueryLog();
      //   print_r($order); exit;
        if ($order) {
            return  new TrackOrderResource($order);
            //  $order['restaurant'] = $order['restaurant'] ? Helper::restaurant_data_formatting($order['restaurant']) : $order['restaurant'];
            //  $order['delivery_address'] = $order['delivery_address']?json_decode($order['delivery_address']):$order['delivery_address'];
        } else {
            return false;
        }
        ;
        return ($order);
    }


    public function list_($request, $user_id,$paginate)
    {
        // TODO: Implement list() method.
        //DB::enableQueryLog();
        $order = Order::with(['restaurant'])->where (function ($query) use($request){
            if($request->has('current_order')&& ($request->current_order==1)){
                $query->whereIn('order_status',array('pending','processing','picked_up','confirmed'));
            }elseif ($request->has('latest_order')){
                $query->where('order_status',array('delivered'));
            }else{
                $query->whereIn('order_status',array('delivered','canceled'));
            }


        })->where('user_id' , $user_id)
            -> withCount('details')
            -> orderBy('id','desc');
        if($paginate==true) {
            $order=$order->paginate(10);//config('app.web_pagination')
            // $result=$paginator->get();
            //  print_r($result); exit;
        }else{
            $order=$order->paginate($request->limit, ['*'], 'page', $request->offset);

        }

      //   print_r($order); exit;
        //  $query=   DB::getQueryLog($order);
        // print_r($query); exit;

        return ListOrderResource::collection($order);
        /*  return [
              'total_size' =>$order->total(),
              'limit' => $request->limit,
              'offset' =>  $request->offset,
              'restaurants' => $order->items()
          ];*/

    }

    public function cancel_order($order_id)
    {
        // TODO: Implement cancle_order() method.
        $order= Order::with(['restaurant'])->where(['id'=>$order_id,'order_status'=>'pending'])->first();
        if(!$order)
            return false;

        Order::where('id',$order_id)->update(['order_status'=>'canceled','canceled'=>now()]);
        return true;
    }

    public function get_order_details($order_id)
    {
        // TODO: Implement get_order_details() method.
        $details = OrderDetail::where(['order_id' =>$order_id])->with('food')->get();
        /* foreach ($details as $det) {
             $det['product_details'] = json_decode($det['product_details'], true);
         }*/
        //  print_r($details); exit;
        return GetOrderResource::collection($details);
    }


}
