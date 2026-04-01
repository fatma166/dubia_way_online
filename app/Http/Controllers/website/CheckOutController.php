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
use App\Models\OrderDetail;
use App\Models\Order;
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
    $cartItems = [];
    $totalPrice = 0;
    $userInfo = null;
    $cat = new CategoryRepository();
    $data['categories'] = $cat->list_cats($request);
    $prev_address = [];
    $zones = Zone::active()->get();
    $delivery_charge = 0;
    $offer_discount = 0;
    $product_price = 0;

    $activeOffer = Offer::where('is_active', 1)->first();

    if (Auth::check()) {
        $userId = Auth::user()->id;
        $cartItems = Cart::where('user_id', $userId)->with('product')->get();

        $address = new OrderRepository();
        $prev_address = $address->get_pervious_address($request);

        if (count($cartItems) == 0) {
            return redirect()->route('products.list')->with('success', __('Add Products To Cart'));
        }

        $b2g1Prices = [];
        $b1g1Prices = [];
        $nonOfferPrices = [];

        foreach ($cartItems as $item) {
            $product = $item->product;
            if (!$product) continue;

            $categoryId = $product->category_id;
            $quantity = $item->quantity;
            $price = $item->price;

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

        // Apply B2G1
        if (count($b2g1Prices) >= 3) {
            sort($b2g1Prices);
            $free = floor(count($b2g1Prices) / 3);
            $discount = array_sum(array_slice($b2g1Prices, 0, $free));
            $offer_discount += $discount;
            $totalPrice += array_sum($b2g1Prices) - $discount;
        } else {
            $totalPrice += array_sum($b2g1Prices);
        }

        // Apply B1G1
        if (count($b1g1Prices) >= 2) {
            sort($b1g1Prices);
            $free = floor(count($b1g1Prices) / 2);
            $discount = array_sum(array_slice($b1g1Prices, 0, $free));
            $offer_discount += $discount;
            $totalPrice += array_sum($b1g1Prices) - $discount;
        } else {
            $totalPrice += array_sum($b1g1Prices);
        }

        // Add items without offers
        $totalPrice += array_sum($nonOfferPrices);

        // Add delivery charge
        if (isset($userInfo->zone->per_km_shipping_charge)) {
            $delivery_charge = $userInfo->zone->per_km_shipping_charge;
            $totalPrice += $delivery_charge;
        } else {
            $vendor_data = Restaurant::find(config('app.default_vendor'));
            $delivery_charge = $vendor_data['delivery_charge'];
            $totalPrice += $delivery_charge;
        }
    } else {
        
                  // For guest users
      // For guest user


$cartItems = session()->get('cart', []);

if (array_sum(array_column($cartItems, 'quantity')) == 0) {
    return redirect()->route('products.list')->with('success', __('Add Products To Cart'));
}

$totalPrice = 0;
$product_price = 0;
$offer_discount = 0;
$unit_prices_B2G1 = [];
$unit_prices_B1G1 = [];
$unit_prices_normal = [];

$b2g1Offer = Offer::where('is_active', 1)->where('type', 'buy_two_get_one_free')->first();
$b1g1Offer = Offer::where('is_active', 1)->where('type', 'buy_one_get_one_free')->first();
$belongsToB2G1_count=0;
foreach ($cartItems as $item) {
    $product_id = $item['id'] ?? $item->id;
    $quantity = $item['quantity'] ?? $item->quantity;
    $price = $item['price'] ?? $item->price;

    $product = Food::find($product_id);
    if (!$product) continue;

    $price_after = $price;
    if ($product->discount_type === 'percent') {
        $price_after -= ($price * $product->discount / 100);
    } else {
        $price_after -= $product->discount;
    }

    $belongsToB2G1 = $b2g1Offer && $b2g1Offer->category_id && $product->category_id == $b2g1Offer->category_id;

    for ($i = 0; $i < $quantity; $i++) {
        if ($belongsToB2G1) {
            ++$belongsToB2G1_count;
            $unit_prices_B2G1[] = $price_after;
        } elseif ($b1g1Offer) {
            $unit_prices_B1G1[] = $price_after;
        } else {
            $unit_prices_normal[] = $price_after;
        }
    }
}

// === Apply B2G1 Offer ===
if (count($unit_prices_B2G1) >= 3) {
    
    sort($unit_prices_B2G1);
    $free = floor(count($unit_prices_B2G1) / 3);
    $discount = array_sum(array_slice($unit_prices_B2G1, 0, $free));
    $offer_discount += $discount;
    $product_price += array_sum($unit_prices_B2G1) - $discount;
} else {
    $product_price += array_sum($unit_prices_B2G1);
}

// === Apply B1G1 Offer ===
if (count($unit_prices_B1G1) >= 2) {
    echo count($unit_prices_B1G1);
    sort($unit_prices_B1G1);
    $free = floor(count($unit_prices_B1G1) / 2);
    $discount = array_sum(array_slice($unit_prices_B1G1, 0, $free));
    $offer_discount += $discount;
    $product_price += array_sum($unit_prices_B1G1) - $discount;
} else {
    $product_price += array_sum($unit_prices_B1G1);
}

// === Add products with no offer ===
$product_price += array_sum($unit_prices_normal);

// === Final Total ===
$totalPrice = $product_price;




/*$cartItems = session()->get('cart', []);

if (array_sum(array_column($cartItems, 'quantity')) == 0) {
    return redirect()->route('products.list')->with('success', __('Add Products To Cart'));
}

$totalPrice = 0;
$product_price = 0;
$offer_discount = 0;
$unit_prices_B2G1 = [];
$unit_prices_B1G1 = [];
$unit_prices_normal = [];


$b2g1Offer = Offer::where('is_active', 1)->where('type', 'buy_two_get_one_free')->first();
$b1g1Offer = Offer::where('is_active', 1)->where('type', 'buy_one_get_one_free')->first();

foreach ($cartItems as $item) {
    $product_id = $item['id'] ?? $item->id;
    $quantity = $item['quantity'] ?? $item->quantity;
    $price = $item['price'] ?? $item->price;

    $product = Food::find($product_id);
    if (!$product) continue;

    $price_after = $price;
    if ($product->discount_type === 'percent') {
        $price_after -= ($price * $product->discount / 100);
    } else {
        $price_after -= $product->discount;
    }

    $belongsToB2G1 = $b2g1Offer && $b2g1Offer->category_id && $product->category_id == $b2g1Offer->category_id;
    $belongsToB1G1 = $b1g1Offer && (!$b1g1Offer->category_id || $product->category_id == $b1g1Offer->category_id);

    for ($i = 0; $i < $quantity; $i++) {
        if ($belongsToB2G1) {
            $unit_prices_B2G1[] = $price_after;
        } elseif ($belongsToB1G1) {
            $unit_prices_B1G1[] = $price_after;
        } else {
            $unit_prices_normal[] = $price_after;
        }
    }
}

// === Apply B2G1 Offer ===
if (count($unit_prices_B2G1) >= 3) {
    sort($unit_prices_B2G1);
    $free = floor(count($unit_prices_B2G1) / 3);
    $discount = array_sum(array_slice($unit_prices_B2G1, 0, $free));
    $offer_discount += $discount;
    $product_price += array_sum($unit_prices_B2G1) - $discount;
} else {
    $product_price += array_sum($unit_prices_B2G1);
}

// === Apply B1G1 Offer ===
if (count($unit_prices_B1G1) >= 2) {
    sort($unit_prices_B1G1);
    $free = floor(count($unit_prices_B1G1) / 2);
    $discount = array_sum(array_slice($unit_prices_B1G1, 0, $free));
    $offer_discount += $discount;
    $product_price += array_sum($unit_prices_B1G1) - $discount;
} else {
    $product_price += array_sum($unit_prices_B1G1);
}

// === Add products with no offer ===
$product_price += array_sum($unit_prices_normal);

// === Final Total ===
$totalPrice = $product_price;*/
    }

    return view('website-views.checkout.index', compact('cartItems', 'totalPrice', 'data', 'userInfo', 'zones', 'prev_address', 'delivery_charge', 'offer_discount'));
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
        $items= OrderDetail::where('order_id',$orderId)->with('food')->get();
        $shipping=0.00;
        $tax=0.00;
        $subtotal=$totalAmount;
        $order=Order::where('id',$orderId)->with('customer_address')->first();
       // dd($order->customer_address['contact_person_number']);
        $hashedPhone =hash('sha256', $order->customer_address['contact_person_number']);
        $hashedEmail =hash('sha256', $order->customer_address['contact_person_name']);

        return view('website-views.checkout.success', compact('orderId', 'totalAmount', 'currency','items','subtotal','shipping','tax','hashedPhone','hashedEmail'));
    }
	   

}