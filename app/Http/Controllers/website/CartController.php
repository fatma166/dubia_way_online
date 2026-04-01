<?php
namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\CentralLogics\CategoryLogic;
use App\CentralLogics\Helpers;
use App\Models\Cart;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Api\CategoryRepository;
class CartController extends Controller
{
    public function index(Request $request)
    {
        $cat=new CategoryRepository();
        $data['categories'] = $cat->list_cats($request);

        if (Auth::check()) {
            // For logged-in users
            $userId = Auth::id();
            $cartItems = Cart::where('user_id', $userId)->with('product')->get();
           // print_r(  $cartItems ); exit;
        } else {

            // For guest users
            $cartItems = session()->get('cart', []);
         //   print_r($cartItems); exit;
        }

        return view('website-views.cart.index', compact('cartItems','data'));
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
            $userId = Auth::guard('web')->user()->id;
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
                // Determine price
                $product = Food::find($productId);
                $price = $product->price;
                if ($request->has('variations') && !empty($request->variations)) {
                    $variation = json_decode($request->variations);
                    if (isset($variation->price)) {
                        $price = $variation->price;
                    }
                }
                // Create a new cart item
                Cart::create([
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'variations'=>$request->variations,
                    'price' => $price
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

                $variation = json_decode($request->variations);
                 if(empty($variation)){
                     $price= $product['price'];
                 }else {

                     $price =$variation->price;
                 }
               // print_r($price);
             //   print_r($variation); exit;
                $cart[$productId] = [

                    'name' => $product['name'], // Fetch product name from DB if needed
                    'quantity' => $quantity,
                    'variations'=>$request->variations,
                   // 'price' => $product['price'], // Fetch price from DB if needed
                    'price'=>$price,
                    'id' => $productId,
                    'image' => $product['image'],
                    'discount' => $product['discount'], // optional
                    'discount_type' => $product['discount_type'] // optional
                ];
            }

            session()->put('cart', $cart);
        }

        // Calculate cart count to return it
        $count = 0;
        if (Auth::check()) {
            $count = Cart::where('user_id', Auth::id())->sum('quantity');
        } else {
            $cart = session()->get('cart', []);
            $count = array_sum(array_column($cart, 'quantity'));
        }

        // جلب بيانات القائمة الجانبية لإرجاعها مباشرة (لتسريع العرض)
        $drawerResponse = $this->side_drawer_view();
        $drawerData = $drawerResponse->getData();

        return response()->json([
            'success' => 'Product added to cart successfully!',
            'cart_count' => $count,
            'count' => $count,
            'view' => $drawerData->view,
            'total' => $drawerData->total
        ]);
    }

    public function update(Request $request)
    {
        if (Auth::check()) {
            // For logged-in users
            $userId = Auth::id();
            $cartItem = Cart::where('user_id', $userId)->where('product_id', $request->id)->first();

            if ($cartItem) {
                $cartItem->quantity = $request->quantity;
                $cartItem->save();
            }
        } else {
            // For guest users
            $cart = session()->get('cart', []);
            if (isset($cart[$request->id])) {
                $cart[$request->id]['quantity'] = $request->quantity;
                session()->put('cart', $cart);
            }
        }

        return response()->json(['success' => 'Cart updated successfully!']);
    }

    public function remove(Request $request)
    {
        if (Auth::check()) {
            // For logged-in users
            Cart::where('user_id', Auth::id())->where('product_id', $request->id)->delete();
        } else {
            // For guest users
            $cart = session()->get('cart', []);
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
        }

        return response()->json(['success' => 'Item removed successfully!']);
    }

    public function getSideCartView()
    {
        return $this->side_drawer_view();
    }

    public function side_drawer_view()
    {
        $cart = [];
        $total = 0;
        $cart_count = 0;

        if (Auth::check()) {
            $userId = Auth::id();
            $cartItems = Cart::where('user_id', $userId)->with('product')->get();

            foreach ($cartItems as $item) {
                if ($item->product) {
                    $cart_count += $item->quantity;
                    $price = $item->price; // Price with variation is expected to be stored in cart

                    // Apply product discount
                    $price_after_discount = $price;
                    if ($item->product->discount > 0) {
                        if ($item->product->discount_type == 'percent') {
                            $price_after_discount -= ($price * $item->product->discount / 100);
                        } else {
                            $price_after_discount -= $item->product->discount;
                        }
                    }

                    $cart[] = [
                        'key' => $item->product->id,
                        'id' => $item->product->id,
                        'name' => $item->product->name,
                        'quantity' => $item->quantity,
                        'price' => $price_after_discount,
                        'thumbnail' => $item->product->image,
                        'variations' => $item->variations,
                    ];
                    $total += $price_after_discount * $item->quantity;
                }
            }
        } else {
            $sessionCart = session('cart', []);
            foreach ($sessionCart as $key => $item) {
                $cart_count += $item['quantity'];
                $price = $item['price'];

                // Apply product discount from session
                $price_after_discount = $price;
                if (isset($item['discount']) && $item['discount'] > 0) {
                    if ($item['discount_type'] == 'percent') {
                        $price_after_discount -= ($price * $item['discount'] / 100);
                    } else {
                        $price_after_discount -= $item['discount'];
                    }
                }

                $cart[] = ['key' => $key, 'id' => $item['id'], 'name' => $item['name'], 'quantity' => $item['quantity'], 'price' => $price_after_discount, 'thumbnail' => $item['image'], 'variations' => $item['variations']];
                $total += $price_after_discount * $item['quantity'];
            }
        }

        $view = view('website-views.partials._side-cart-items', compact('cart'))->render();

        return response()->json([
            'view' => $view,
            'total' => $total . ' ' . config('app.currency'),
            'count' => $cart_count
        ]);
    }

}