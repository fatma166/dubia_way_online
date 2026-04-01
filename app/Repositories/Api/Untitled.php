<?php
namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\CentralLogics\CategoryLogic;
use App\CentralLogics\Helpers;
use App\Http\Requests\Api\CouponCheckRequest;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Food;
use App\Models\Offer;
use App\Models\Restaurant;
use App\Models\Zone;
use App\Repositories\Api\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Api\CategoryRepository;
use App\Http\Requests\Api\OrderRequest;
use App\Modules\Core\HTTPResponseCodes;
use App\Modules\Core\Helper;
class CheckOutController extends Controller
{
    public function index(Request $request)
    {
         
        $cartItems= [];
        $totalPrice = 0;
        $userInfo = null;
        $cat=new CategoryRepository();
        $data['categories'] = $cat->list_cats($request);
        $prev_address=[];
        $zones=Zone::active()->get();
        $delivery_charge=0;
        $offer_discount=0;
        $product_price=0;
		$activeOffer = Offer::where('is_active',1)->first();
        if (Auth::check()) {
            // For logged-in users
            $userId = Auth::user()->id;

            $cartItems = Cart::where('user_id', $userId)->with('product')->get();

           // $userId = Auth::id();
           // $userInfo = User::with('zone')->find($userId); // Get user info

            $address=new OrderRepository();
            $prev_address = $address->get_pervious_address($request);
          $totalPrice=0;
	      $offer_discount=0;
			$product_price=0;
           
			  // offers code
	   // Check for active offers
    
if(count($cart_items)==0){
    //exit;
      return redirect()->route('products.list')->with('success', __('Add Products To Cart'));
}
 
/*if ($activeOffer && $activeOffer->type == 'buy_two_get_one_free') {
    
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
			$offer_discount=$lowest_price * $freeItems;
        }
	$totalPrice=$product_price;
}*/

/*elseif ($activeOffer && $activeOffer->type == 'buy_one_get_one_free') {
   
    // Logic for Buy One Get One Free
    $totalItems = array_sum(array_column($cart_items, 'quantity'));
    if ($totalItems >= 2) {
        // Gather prices of all products in the cart
        $prices = [];
        $product_price = 0;

        foreach ($cart_items as $item) {

            if (isset($item->id)) {
                $product_id_ = $item->id;
            } else {
                $product_id_ = $item['id'];
            }

            if (isset($item->quantity)) {
                $product_quantity_ = $item->quantity;
            } else {
                $product_quantity_ = $item['quantity'];
            }

            if (isset($item->price)) {
                $product_price_ = $item->price;
            } else {
                $product_price_ = $item['price'];
            }

            $product_data = Food::where('id', $product_id_)->first();
            $price_after = $product_price_;

            if ($product_data['discount_type'] == "percent") {
                $price_after -= ($product_price_ * $product_data['discount'] / 100);
            } else {
                $price_after -= $product_data['discount'];
            }

            // Add total product price
            $product_price += ($price_after * $product_quantity_);

            // Store price per unit for BOGO logic
            for ($i = 0; $i < $product_quantity_; $i++) {
                $prices[] = $price_after;
            }
        }

        // Sort prices to find the lowest
        sort($prices);
        $freeItems = floor($totalItems / 2); // 1 free for each 2 items
        $lowest_price = array_slice($prices, 0, $freeItems); // lowest N items
        $offer_discount = array_sum($lowest_price);

        // Apply discount
        $product_price -= $offer_discount;
    }
//echo $product_price; exit;
    $totalPrice = $product_price;
}*/
/* elseif ($activeOffer && $activeOffer->type == 'buy_one_get_one_free') {

    $totalItems = 0;
    $unitPrices = []; // For storing individual unit prices

    foreach ($cart_items as $item) {
        $product_id = isset($item->id) ? $item->id : $item['id'];
        $quantity = isset($item->quantity) ? $item->quantity : $item['quantity'];
        $price = isset($item->price) ? $item->price : $item['price'];

        $product = Food::find($product_id);
        $finalPrice = $price;

        // Apply discount
        if ($product && $product->discount > 0) {
            if ($product->discount_type === "percent") {
                $finalPrice -= ($price * $product->discount / 100);
            } else {
                $finalPrice -= $product->discount;
            }
        }

        // Add each unit separately for sorting later
        for ($i = 0; $i < $quantity; $i++) {
            $unitPrices[] = $finalPrice;
            $totalItems++;
        }
    }

    if ($totalItems >= 2) {
        // Sort unit prices to find cheapest items to be free
        sort($unitPrices);

        $freeItemCount = floor($totalItems / 2); // Every second item is free
        $paidItems = array_slice($unitPrices, $freeItemCount); // Keep the more expensive half
        $totalPrice = array_sum($paidItems);
    } else {
        $totalPrice = array_sum($unitPrices); // No offer applies
    }
}
else{
	
	 foreach ($cartItems as $item) {
           // print_r($item['product']['price']-$item['product']['discount']); exit;
                if($item['product']['discount_type']=='fixed'){
                    $totalPrice += $item['quantity'] * ($item['product']['price']-$item['product']['discount']); // Calculate total price
                }else{
                    $totalPrice += $item['quantity'] * ($item['product']['price']-($item['product']['price']* $item['product']['discount']/ 100)); // Calculate total price
                }
               // echo $totalPrice; exit;
            }
	
	
	
}*/
/////////////////////////////////////////////////////////////////////////////////

/***if ($activeOffer && $activeOffer->type == 'buy_two_get_one_free') {

    $matchingUnitPrices = [];       // Items eligible for buy 2 get 1
    $nonMatchingUnitPrices = [];    // Items NOT eligible for buy 2 get 1

    foreach ($cart_items as $item) {
        $product_id = $item->id ?? $item['id'];
        $quantity = $item->quantity ?? $item['quantity'];
        $price = $item->price ?? $item['price'];

        $product = Food::find($product_id);
        if (!$product) continue;

        $finalPrice = $price;
        if ($product->discount_type === 'percent') {
            $finalPrice -= ($price * $product->discount / 100);
        } else {
            $finalPrice -= $product->discount;
        }

        $isEligible = true;
        if ($activeOffer->category_id && $product->category_id != $activeOffer->category_id) {
            $isEligible = false;
        }
        if ($activeOffer->applies_to_size && $product->size != $activeOffer->applies_to_size) {
            $isEligible = false;
        }

        for ($i = 0; $i < $quantity; $i++) {
            if ($isEligible) {
                $matchingUnitPrices[] = $finalPrice;
            } else {
                $nonMatchingUnitPrices[] = $finalPrice;
            }
        }
    }

    // Apply Buy 2 Get 1 on eligible items
    $offer_discount = 0;
    $product_price = 0;
    $eligibleCount = count($matchingUnitPrices);

    if ($eligibleCount >= 3) {
        sort($matchingUnitPrices);
        $freeItems = floor($eligibleCount / 3);
        $offer_discount = array_sum(array_slice($matchingUnitPrices, 0, $freeItems));
        $product_price = array_sum($matchingUnitPrices) - $offer_discount;
    } else {
        $product_price = array_sum($matchingUnitPrices);
    }

    // ? Now process non-matching items as Buy 1 Get 1 if offer is active
    if ($activeOffer && $activeOffer->type == 'buy_two_get_one_free' && count($nonMatchingUnitPrices) >= 2) {
        sort($nonMatchingUnitPrices);
        $freeInBOGO = floor(count($nonMatchingUnitPrices) / 2);
        $discountInBOGO = array_sum(array_slice($nonMatchingUnitPrices, 0, $freeInBOGO));
        $product_price += (array_sum($nonMatchingUnitPrices) - $discountInBOGO);
    } else {
        // If no BOGO fallback, just add as normal
        $product_price += array_sum($nonMatchingUnitPrices);
    }

    $totalPrice = $product_price;

} elseif ($activeOffer && $activeOffer->type == 'buy_one_get_one_free') {

    $unitPrices = [];
    $totalItems = 0;

    foreach ($cart_items as $item) {
        $product_id = $item->id ?? $item['id'];
        $quantity = $item->quantity ?? $item['quantity'];
        $price = $item->price ?? $item['price'];

        $product = Food::find($product_id);
        $finalPrice = $price;

        if ($product && $product->discount > 0) {
            if ($product->discount_type === "percent") {
                $finalPrice -= ($price * $product->discount / 100);
            } else {
                $finalPrice -= $product->discount;
            }
        }

        for ($i = 0; $i < $quantity; $i++) {
            $unitPrices[] = $finalPrice;
            $totalItems++;
        }
    }

    if ($totalItems >= 2) {
        sort($unitPrices);
        $freeItemCount = floor($totalItems / 2);
        $paidItems = array_slice($unitPrices, $freeItemCount);
        $totalPrice = array_sum($paidItems);
    } else {
        $totalPrice = array_sum($unitPrices);
    }

} else {

    // No offer active
    $totalPrice = 0;
    foreach ($cart_items as $item) {
        $product = Food::find($item['id']);
        $price = $item['product']['price'];
        $discount = $item['product']['discount'];
        $quantity = $item['quantity'];

        if ($item['product']['discount_type'] == 'fixed') {
            $totalPrice += $quantity * ($price - $discount);
        } else {
            $totalPrice += $quantity * ($price - ($price * $discount / 100));
        }
    }

}****/
$totalPrice = 0;
$offer_discount = 0;

$b2g1Prices = [];
$b1g1Prices = [];
$nonOfferPrices = [];

foreach ($cart_items as $item) {
    $product_id = $item->id ?? $item['id'];
    $quantity = $item->quantity ?? $item['quantity'];
    $price = $item->price ?? $item['price'];

    $product = Food::find($product_id);
    if (!$product) continue;

    // Apply any product-specific discount
    $finalPrice = $price;
    if ($product->discount_type === 'percent') {
        $finalPrice -= ($price * $product->discount / 100);
    } else {
        $finalPrice -= $product->discount;
    }

    for ($i = 0; $i < $quantity; $i++) {
        $isEligibleForB2G1 = false;
        $isEligibleForB1G1 = false;

        if ($activeOffer) {
            if ($activeOffer->type === 'buy_two_get_one_free') {
                if (
                    (!$activeOffer->category_id || $product->category_id == $activeOffer->category_id) &&
                    (!$activeOffer->applies_to_size || $product->size == $activeOffer->applies_to_size)
                ) {
                    $isEligibleForB2G1 = true;
                }
            }

            if ($activeOffer->type === 'buy_one_get_one_free') {
                if (
                    (!$activeOffer->category_id || $product->category_id == $activeOffer->category_id) &&
                    (!$activeOffer->applies_to_size || $product->size == $activeOffer->applies_to_size)
                ) {
                    $isEligibleForB1G1 = true;
                }
            }
        }

        // Add item price to correct bucket
        if ($isEligibleForB2G1) {
            $b2g1Prices[] = $finalPrice;
        } elseif ($isEligibleForB1G1) {
            $b1g1Prices[] = $finalPrice;
        } else {
            $nonOfferPrices[] = $finalPrice;
        }
    }
}

// --- Apply B2G1 ---
if (count($b2g1Prices) >= 3) {
    sort($b2g1Prices);
    $free = floor(count($b2g1Prices) / 3);
    $discount = array_sum(array_slice($b2g1Prices, 0, $free));
    $offer_discount += $discount;
    $totalPrice += array_sum($b2g1Prices) - $discount;
} else {
    $totalPrice += array_sum($b2g1Prices);
}

// --- Apply B1G1 ---
if (count($b1g1Prices) >= 2) {
    sort($b1g1Prices);
    $free = floor(count($b1g1Prices) / 2);
    $discount = array_sum(array_slice($b1g1Prices, 0, $free));
    $offer_discount += $discount;
    $totalPrice += array_sum($b1g1Prices) - $discount;
} else {
    $totalPrice += array_sum($b1g1Prices);
}

// --- Add items not in any offer ---
$totalPrice += array_sum($nonOfferPrices);

// Return final result
return [
    'status' => 'true',
    'order_amount' => round($totalPrice, 2),
    'total_price' => $totalPrice,
    'coupon_discount_amount' => 0,
    'tax' => 0,
    'shipping_coast' => $restaurant->delivery_charge ?? 0,
    'product_price' => $totalPrice,
    'offer_discount_amount' => $offer_discount,
];

////////////////////////////////////////////////////////////////////////////////
/*if ($activeOffer && $activeOffer->type == 'buy_two_get_one_free') {

    $matchingUnitPrices = []; // Prices of eligible items
    $nonMatchingUnitPrices = []; // Prices of items not eligible for the offer

    foreach ($cart_items as $item) {
        $product_id = isset($item->id) ? $item->id : $item['id'];
        $quantity = isset($item->quantity) ? $item->quantity : $item['quantity'];
        $price = isset($item->price) ? $item->price : $item['price'];

        $product = Food::find($product_id);
        if (!$product) continue;

        // Apply product-level discount
        $finalPrice = $price;
        if ($product->discount_type == "percent") {
            $finalPrice -= ($price * $product->discount / 100);
        } else {
            $finalPrice -= $product->discount;
        }

        // Check if product is eligible for this offer
        $isEligible = true;
        if ($activeOffer->category_id && $product->category_id != $activeOffer->category_id) {
            $isEligible = false;
        }
        if ($activeOffer->applies_to_size && $product->size != $activeOffer->applies_to_size) {
            $isEligible = false;
        }

        for ($i = 0; $i < $quantity; $i++) {
            if ($isEligible) {
                $matchingUnitPrices[] = $finalPrice;
            } else {
                $nonMatchingUnitPrices[] = $finalPrice;
            }
        }
    }

    // Calculate total for eligible products
    $eligibleCount = count($matchingUnitPrices);
    $offer_discount = 0;
    $product_price = 0;

    if ($eligibleCount >= 3) {
        sort($matchingUnitPrices);
        $freeItems = floor($eligibleCount / 3);
        $offer_discount = array_sum(array_slice($matchingUnitPrices, 0, $freeItems));
        $product_price = array_sum($matchingUnitPrices) - $offer_discount;
    } else {
        $product_price = array_sum($matchingUnitPrices);
    }

    // Add the total of non-eligible items
    $product_price += array_sum($nonMatchingUnitPrices);

    $totalPrice = $product_price;

} elseif ($activeOffer && $activeOffer->type == 'buy_one_get_one_free') {

    $totalItems = 0;
    $unitPrices = [];

    foreach ($cart_items as $item) {
        $product_id = isset($item->id) ? $item->id : $item['id'];
        $quantity = isset($item->quantity) ? $item->quantity : $item['quantity'];
        $price = isset($item->price) ? $item->price : $item['price'];

        $product = Food::find($product_id);
        $finalPrice = $price;

        if ($product && $product->discount > 0) {
            if ($product->discount_type === "percent") {
                $finalPrice -= ($price * $product->discount / 100);
            } else {
                $finalPrice -= $product->discount;
            }
        }

        for ($i = 0; $i < $quantity; $i++) {
            $unitPrices[] = $finalPrice;
            $totalItems++;
        }
    }

    if ($totalItems >= 2) {
        sort($unitPrices);
        $freeItemCount = floor($totalItems / 2);
        $paidItems = array_slice($unitPrices, $freeItemCount);
        $totalPrice = array_sum($paidItems);
    } else {
        $totalPrice = array_sum($unitPrices);
    }

} else {

    // Regular total calculation if no active offer
    $totalPrice = 0;
    foreach ($cartItems as $item) {
        $price = $item['product']['price'];
        $discount = $item['product']['discount'];
        $quantity = $item['quantity'];

        if ($item['product']['discount_type'] == 'fixed') {
            $totalPrice += $quantity * ($price - $discount);
        } else {
            $totalPrice += $quantity * ($price - ($price * $discount / 100));
        }
    }

}*/////////////////


            if(isset($userInfo->zone->per_km_shipping_charge)) {
                $delivery_charge=$userInfo->zone->per_km_shipping_charge;
                $totalPrice = $totalPrice + $userInfo->zone->per_km_shipping_charge;
            }else{
                $vendor_data=Restaurant::find(config('app.default_vendor'));
                $delivery_charge=$vendor_data['delivery_charge'];
                $totalPrice = $totalPrice + $vendor_data['delivery_charge'];
            }
        } else {

            // For guest users
// For guest users
$cartItems = session()->get('cart', []);

if (array_sum(array_column($cartItems, 'quantity')) == 0) {
    return redirect()->route('products.list')->with('success', __('Add Products To Cart'));
}

$totalPrice = 0;
$offer_discount = 0;
$product_price = 0;

$b2g1Prices = [];
$b1g1Prices = [];
$nonOfferPrices = [];

foreach ($cartItems as $item) {
    $productId = $item['id'] ?? null;
    $quantity = $item['quantity'] ?? 0;
    $price = $item['price'] ?? 0;

    $product = \App\Models\Food::find($productId);
    if (!$product) continue;

    $finalPrice = $price;
    if ($product->discount_type === 'percent') {
        $finalPrice -= ($price * $product->discount / 100);
    } else {
        $finalPrice -= $product->discount;
    }

    for ($i = 0; $i < $quantity; $i++) {
        $isEligibleForB2G1 = false;
        $isEligibleForB1G1 = false;

        if ($activeOffer) {
            if ($activeOffer->type === 'buy_two_get_one_free') {
                if (
                    (!$activeOffer->category_id || $product->category_id == $activeOffer->category_id) &&
                    (!$activeOffer->applies_to_size || $product->size == $activeOffer->applies_to_size)
                ) {
                    $isEligibleForB2G1 = true;
                }
            }

            if ($activeOffer->type === 'buy_one_get_one_free') {
                if (
                    (!$activeOffer->category_id || $product->category_id == $activeOffer->category_id) &&
                    (!$activeOffer->applies_to_size || $product->size == $activeOffer->applies_to_size)
                ) {
                    $isEligibleForB1G1 = true;
                }
            }
        }

        if ($isEligibleForB2G1) {
            $b2g1Prices[] = $finalPrice;
        } elseif ($isEligibleForB1G1) {
            $b1g1Prices[] = $finalPrice;
        } else {
            $nonOfferPrices[] = $finalPrice;
        }
    }
}

// Apply B2G1 logic
if (count($b2g1Prices) >= 3) {
    sort($b2g1Prices);
    $free = floor(count($b2g1Prices) / 3);
    $discount = array_sum(array_slice($b2g1Prices, 0, $free));
    $offer_discount += $discount;
    $totalPrice += array_sum($b2g1Prices) - $discount;
} else {
    $totalPrice += array_sum($b2g1Prices);
}

// Apply B1G1 logic
if (count($b1g1Prices) >= 2) {
    sort($b1g1Prices);
    $free = floor(count($b1g1Prices) / 2);
    $discount = array_sum(array_slice($b1g1Prices, 0, $free));
    $offer_discount += $discount;
    $totalPrice += array_sum($b1g1Prices) - $discount;
} else {
    $totalPrice += array_sum($b1g1Prices);
}

// Add non-offer products
$totalPrice += array_sum($nonOfferPrices);

        
		}
      //  print_r($cartItems);exit;
        return view('website-views.checkout.index', compact('cartItems','totalPrice','data','userInfo','zones','prev_address','delivery_charge','offer_discount'));
    }
    public function addToCart(Request $request)
    {
        /*if (!Auth::check()) {
            return response()->json(['error' => 'You must be logged in to add items to your cart.'], 403);
        }*/
        $request->validate([
            'product_id' => 'required|exists:food,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request->product_id;
        $quantity = $request->quantity;

        if (Auth::check()) {
            // For logged-in users, store in the database
            $userId = Auth::id();
            $productId = $request->product_id;
            $quantity = $request->quantity;

            // Check if the product is already in the cart
            $cartItem = Cart::where('user_id', $userId)
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {
                // Update quantity if it exists
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                // Create a new cart item
                Cart::create([
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ]);
            }

            return response()->json(['success' => 'Product added to cart successfully!']);
        } else {
            // For guest users, store in the session
            $cart = session()->get('cart', []);

            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += $quantity;
            } else {
                $product= Food::where('id',$productId)->first();
                $cart[$productId] = [
                    'name' => $product['name'], // Fetch product name from DB if needed
                    'quantity' => $quantity,
                    'price' => $product['price'], // Fetch price from DB if needed
                    'id' => $productId,
                    'image' => $product['image'],
                    'discount' => $product['discount'], // optional
                    'discount_type' => $product['discount_type'] // optional
                ];
            }

            session()->put('cart', $cart);
        }

        return response()->json(['success' => 'Product added to cart successfully!']);
    }
    public function cart_order(OrderRequest $request)
    {


       // try {
            $cart=new OrderRepository();
            $cart = $cart->cart_order($request);
         //print_r($cart); exit;
           return $cart;
            /* if($cart==true) {
                return response()->json([
                    'status' => HTTPResponseCodes::Sucess['status'],
                    'message' => HTTPResponseCodes::Sucess['message'],
                    'errors' => [],
                    'data' => [],
                    'code' => HTTPResponseCodes::Sucess['code']
                ], HTTPResponseCodes::Sucess['code']);
           }else{
                return response()->json([
                    'status' =>false,
                    'errors'=>__('error when retrieve data'),
                    'message' =>HTTPResponseCodes::BadRequest['message'],
                    'data' => [],
                    'code'=>HTTPResponseCodes::BadRequest['code']
                ],HTTPResponseCodes::Sucess['code']);
            }*/

      /*  } catch (\Exception $e) {
            return response()->json([
                'status' =>false,
                'errors'=>__('error when retrieve data'),
               // 'message' =>HTTPResponseCodes::BadRequest['message'],
              //  'code'=>HTTPResponseCodes::BadRequest['code']
            ]);
        }*/
    }

    public function check_coupon(CouponCheckRequest $request){
        $coupon=$request['coupon_code'];
        $cart_items_json = html_entity_decode($request['cart_items']);
    
    // Decode JSON string to array
    $cart_items = json_decode($cart_items_json, true);
       // echo $coupon; exit;
        if(isset(Auth::guard('web')->user()->id)){
        $user_id=Auth::guard('web')->user()->id;
        }else{
            $user_id="";
        }
        
        $restaurant_id=config('app.default_vendor');
       // $cart_items=(json_decode($request['cart_items']));
       
       // $cart_items = array_values($cart_items);
        
        $coupon=Coupon::where('code',$coupon)->first();
       
        if(empty($coupon)){
            return response()->json([
                'status' =>false,
                'errors'=>[],
                'message' =>__('coupon not_found'),
                'data' => [],
                'code'=>400
            ],HTTPResponseCodes::Sucess['code']);
            }
        $staus=Helper::is_valide($coupon,$user_id,$restaurant_id,$cart_items);

        if($staus==407)
        {
            return response()->json([
                'status' =>false,
                'errors'=>__('coupon_expire'),
                'message' =>__('coupon_expire'),
                'data' => [],
                'code'=>407
            ],HTTPResponseCodes::Sucess['code']);

        }
        else if($staus==406)
        {
            return response()->json([
                'status' =>false,
                'errors'=>__('coupon_usage_limit_over'),
                'message' =>__('coupon_usage_limit_over'),
                'data' => [],
                'code'=>406
            ],HTTPResponseCodes::Sucess['code']);

        }else if($staus==400){
            return response()->json([
                'status' => false,
                'errors' => __(' food_id not found iin data base') . $coupon['min_purchase'],
                'message' => __('please select correct food_id') ,
                'data' => [],
                'code' => 407
            ], HTTPResponseCodes::Sucess['code']);
        }

        else if($staus==200)
        {
            $amount=new OrderRepository();
            $amount_data = $amount->calcualate_order_amount($request);
            return ($amount_data);
           /* return response()->json([
                'status' =>true,
                'errors'=>[],
                'message' =>__('success'),
                'data' => [],
                'code'=>HTTPResponseCodes::Sucess['code']
            ],HTTPResponseCodes::Sucess['code']);*/
        }
        /* if($coupon->coupon_type == 'free_delivery')
         {
             $delivery_charge = 0;
             $coupon = null;
             $free_delivery_by = 'admin';
         }*/
        else {
            return response()->json([
                'status' =>false,
                'errors'=>[],
                'message' =>$staus,
                'data' => [],
                'code'=>HTTPResponseCodes::BadRequest['code']
            ],HTTPResponseCodes::Sucess['code']);
        }
    }
	   
public function success(Request $request)
    {
        $orderId = $request->query('order_id');
        $totalAmount = $request->query('total_amount');
        $currency = $request->query('currency');

        return view('website-views.checkout.success', compact('orderId', 'totalAmount', 'currency'));
    }
	   

}