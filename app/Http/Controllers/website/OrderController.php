<?php
namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\CentralLogics\CategoryLogic;
use App\CentralLogics\Helpers;
use App\Http\Requests\Api\CouponCheckRequest;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Food;
use App\Models\Restaurant;
use App\Models\Zone;
use App\Repositories\Api\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Api\CategoryRepository;
use App\Http\Requests\Api\OrderRequest;
class OrderController extends Controller
{

    public function index(Request $request){
        if(!Auth::check()){
            $data['type'] = "login";
            return redirect()->route('auth.login')->with('success', __('login first to show your orders'));
        }
        $user_id=Auth::guard('web')->user()->id;
        // try {
        $list_obj = new OrderRepository();
        $list = $list_obj->list_($request, $user_id,true);
        // print_r($list); exit;
        if($request->ajax()){
            return view('website-views.orders.partails._table', compact('list','request'));
        }else {

            return view('website-views.orders.index', compact('list','request'));
        }
    }
    public function details($id){

        $orderdetail= new OrderRepository();
        $cartItems = $orderdetail->get_order_details($id);
       // print_r($cartItems); exit;
        return view('website-views.orders.order_details', compact('cartItems'));
    }


}