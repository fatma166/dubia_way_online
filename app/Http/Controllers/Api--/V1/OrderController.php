<?php

namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CancleOrderRequest;
use App\Http\Requests\Api\CouponCheckRequest;
use App\Http\Requests\Api\ListOrderRequest;
use App\Http\Requests\Api\OrderRequest;
use App\Http\Requests\Api\SingleAddressRequest;
use App\Http\Requests\Api\SingleOrderRequest;
use App\Http\Requests\Api\TrackOrderRequest;
use App\Models\Coupon;
use App\Modules\Core\Helper;
use App\Modules\Core\HTTPResponseCodes;
use App\Repositories\Api\OrderRepository;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Stripe\Stripe;

class OrderController extends Controller
{
    public function generatePaymentLink(Request $request)
    {
      $data=  $this->calcualate_order_amount($request);
        $amount="";
      if(isset($data['status'])&& $data['status']==true){
          $amount=$data['order_amount'];
      }else{
          return response()->json([
              'status' =>false,
              'errors'=>__('error'),
              'message' =>$data['msg'],
              'data' => [],
              'code'=>408
          ],HTTPResponseCodes::Sucess['code']);
      }
        Stripe::setApiKey(config('stripe.secret_key'));

      //  $amount = $request->input('amount');
        $currency = 'USD'; // Change to your desired currency

        $paymentLink = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => $currency,
                        'unit_amount' => $amount * 100, // Stripe requires the amount in cents
                        'product_data' => [
                            'name' => 'Payment',
                        ],
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => config('app.url') . '/success',
            'cancel_url' => config('app.url') . '/cancel',
        ]);

        return response()->json([
            'payment_link' => $paymentLink->url,
        ]);
    }

    public function paymentCallback(Request $request)
    {
        // Retrieve the payment intent ID from the query parameters
        $paymentIntentId = $request->query('payment_intent');
        if($paymentIntentId==""){
            return response()->json([
                'status' =>false,
                'errors'=>[],
                'message' =>__('false roll back'),
                'data' => [],
                'code'=>HTTPResponseCodes::BadRequest['code']
            ],HTTPResponseCodes::Sucess['code']);
        }
         // this block for test
        if ($paymentIntentId === 'test_payment_intent_id') {
            // Store the transaction ID in the session or database for future reference
            $transactionId = 'test_transaction_id';
            Session::put('transaction_id', $transactionId);
        }
        return   $this->success();
            // Retrieve the transaction ID from the Stripe API using the payment intent ID
            Stripe::setApiKey(config('stripe.secret_key'));
            $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);
            $transactionId = $paymentIntent->charges->data[0]->id;

            // Store the transaction ID in the session or database for future reference
              Session::put('transaction_id', $transactionId);

        // Redirect the user to a success or cancellation page in your mobile web view
       // return redirect()->to('/payment/success');
     return   $this->success();
    }
    public function success()
    {
        $sucess=new OrderRepository();
           $sucess->payment_success();
        return response()->json([
            'status' =>true,
            'errors'=>[],
            'message' =>__('success'),
            'data' => [],
            'code'=>HTTPResponseCodes::Sucess['code']
        ],HTTPResponseCodes::Sucess['code']);
    }

    public function check_coupon(CouponCheckRequest $request){
        $coupon=$request->coupon_code;
        $user_id=Auth::guard('api')->user()->id;
        $restaurant_id=isset($request->restaurant_id)?$request->restaurant_id:"";
        $cart_items=$request->cart_items;
        $coupon=Coupon::where('code',$coupon)->first();
        if($coupon=="")
            return response()->json([
                'status' =>false,
                'errors'=>[],
                'message' =>__('coupon not_found'),
                'data' => [],
                'code'=>HTTPResponseCodes::BadRequest['code']
            ],HTTPResponseCodes::Sucess['code']);
        $staus=  Helper::is_valide($coupon, $user_id, $restaurant_id,$cart_items);
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

        }

        else if($staus==200)
        {
            return response()->json([
                'status' =>true,
                'errors'=>[],
                'message' =>__('success'),
                'data' => [],
                'code'=>HTTPResponseCodes::Sucess['code']
            ],HTTPResponseCodes::Sucess['code']);
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
    public function calcualate_order_amount(Request $request){
        //try {
            $cart=new OrderRepository();
            $amount = $cart->calcualate_order_amount($request);
            return $amount;


       /* } catch (\Exception $e) {
            return response()->json([
                'status' =>false,
                'errors'=>__('error when retrieve data'),
                'message' =>HTTPResponseCodes::BadRequest['message'],
                'code'=>HTTPResponseCodes::BadRequest['code']
            ],HTTPResponseCodes::Sucess['code']);
        }*/
    }

    public function cart_order(OrderRequest $request)
    {


        try {
            $cart=new OrderRepository();
            $cart = $cart->cart_order($request);
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

       } catch (\Exception $e) {
            return response()->json([
                'status' =>false,
                'errors'=>__('error when retrieve data'),
                'message' =>HTTPResponseCodes::BadRequest['message'],
                'code'=>HTTPResponseCodes::BadRequest['code']
            ],HTTPResponseCodes::Sucess['code']);
        }
    }

     public function get_pervious_address(Request $request){

         $user_id=Auth::guard('api')->user()->id;


       //  try {
             $pervious_add=new OrderRepository();
             $address=$pervious_add->get_pervious_address($user_id);
             return response()->json([
                 'status' => HTTPResponseCodes::Sucess['status'],
                 'message'=>HTTPResponseCodes::Sucess['message'],
                 'errors' => [],
                 'data' => $address,
                 'code'=>HTTPResponseCodes::Sucess['code']
             ],HTTPResponseCodes::Sucess['code']);

        /* } catch (\Exception $e) {
             return response()->json([
                 'status' =>false,
                 'errors'=>__('error when retrieve data'),
                 'message' =>HTTPResponseCodes::BadRequest['message'],
                 'code'=>HTTPResponseCodes::BadRequest['code']
             ],HTTPResponseCodes::Sucess['code']);
         }*/
     }
     public function get_address(SingleAddressRequest $request){

        $user_id=Auth::guard('api')->user()->id;
        $address_id=$request->address_id;


        //  try {
        $pervious_add=new OrderRepository();
        $address=$pervious_add->get_address($user_id,$address_id);
        return response()->json([
            'status' => HTTPResponseCodes::Sucess['status'],
            'message'=>HTTPResponseCodes::Sucess['message'],
            'errors' => [],
            'data' => $address,
            'code'=>HTTPResponseCodes::Sucess['code']
        ],HTTPResponseCodes::Sucess['code']);

        /* } catch (\Exception $e) {
             return response()->json([
                 'status' =>false,
                 'errors'=>__('error when retrieve data'),
                 'message' =>HTTPResponseCodes::BadRequest['message'],
                 'code'=>HTTPResponseCodes::BadRequest['code']
             ],HTTPResponseCodes::Sucess['code']);
         }*/
    }



    public function track_order(TrackOrderRequest $request){


        $order_id=$request->order_id;
        $user_id=Auth::guard('api')->user()->id;
       // try {
            $track = new OrderRepository();
            $order_track = $track->track_order($order_id, $user_id);
            if ($order_track == false) {
                return response()->json([
                    'status' => false,
                    'errors' => __('error when retrieve data'),
                    'message' => HTTPResponseCodes::BadRequest['message'],
                    'code' => HTTPResponseCodes::BadRequest['code']
                ], HTTPResponseCodes::Sucess['code']);
            }

            return response()->json([
                'status' => HTTPResponseCodes::Sucess['status'],
                'message' => HTTPResponseCodes::Sucess['message'],
                'errors' => [],
                'data' => $order_track,
                'code' => HTTPResponseCodes::Sucess['code']
            ], HTTPResponseCodes::Sucess['code']);
        //}
        /* } catch (\Exception $e) {
             return response()->json([
                 'status' =>false,
                 'errors'=>__('error when retrieve data'),
                 'message' =>HTTPResponseCodes::BadRequest['message'],
                 'code'=>HTTPResponseCodes::BadRequest['code']
             ],HTTPResponseCodes::Sucess['code']);
         }*/

     }

     public function list_(ListOrderRequest $request){

        $user_id=Auth::guard('api')->user()->id;
       // try {
            $list_obj = new OrderRepository();
            $list = $list_obj->list_($request, $user_id);
            return response()->json([
                'status' => HTTPResponseCodes::Sucess['status'],
                'message' => HTTPResponseCodes::Sucess['message'],
                'errors' => [],
                'data' => $list,
                'code' => HTTPResponseCodes::Sucess['code']
            ], HTTPResponseCodes::Sucess['code']);
      /* } catch (\Exception $e) {
             return response()->json([
                 'status' =>false,
                 'errors'=>__('error when retrieve data'),
                 'message' =>HTTPResponseCodes::BadRequest['message'],
                 'code'=>HTTPResponseCodes::BadRequest['code']
             ],HTTPResponseCodes::Sucess['code']);
         }*/

     }

     public function cancel_order(CancleOrderRequest $request){
        try {
            $obj = new OrderRepository();
            $cancle = $obj->cancel_order($request->order_id);
            if ($cancle == false)
                return response()->json([
                    'status' => false,
                    'errors' => __('order is procced'),
                    'message' => HTTPResponseCodes::InvalidArguments['message'],
                    'code' => HTTPResponseCodes::InvalidArguments['code']
                ], HTTPResponseCodes::Sucess['code']);
            return response()->json([
                'status' => HTTPResponseCodes::Sucess['status'],
                'message' => HTTPResponseCodes::Sucess['message'],
                'errors' => [],
                'data' => [],
                'code' => HTTPResponseCodes::Sucess['code']
            ], HTTPResponseCodes::Sucess['code']);
        } catch (\Exception $e) {
            return response()->json([
                'status' =>false,
                'errors'=>__('error when retrieve data'),
                'message' =>HTTPResponseCodes::BadRequest['message'],
                'code'=>HTTPResponseCodes::BadRequest['code']
            ],HTTPResponseCodes::Sucess['code']);
        }
     }

    public function get_order_details(SingleOrderRequest $request){
        try {
            $single_order = new OrderRepository();
            $details=$single_order->get_order_details($request->order_id);
            return response()->json([
                'status' => HTTPResponseCodes::Sucess['status'],
                'message' => HTTPResponseCodes::Sucess['message'],
                'errors' => [],
                'data' => $details,
                'code' => HTTPResponseCodes::Sucess['code']
            ], HTTPResponseCodes::Sucess['code']);
        } catch (\Exception $e) {
            return response()->json([
                'status' =>false,
                'errors'=>__('error when retrieve data'),
                'message' =>HTTPResponseCodes::BadRequest['message'],
                'code'=>HTTPResponseCodes::BadRequest['code']
            ],HTTPResponseCodes::Sucess['code']);
        }
    }


}

