<?php
namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\DeliveryMan;
use App\Models\Food;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderPaymentTransaction;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Wishlist;
use App\Models\OrderTransaction;
use App\Modules\Core\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){

        return view('vendor-views.index');
    }
    public function dashboard(Request $request)
    {
              $now = Carbon::now();
        $month=$now->month;
        if($request->startDate =='')
            $start=Carbon::now()->format('Y')."-".$month."-".'1';
        else
            $start=$request->startDate;
        if($request->endDate =='')
            $end=Carbon::now()->format('Y-m-d');
        else
            $end=$request->endDate;

        /*  $params = [
              'zone_id' => $request['zone_id'] ?? 'all',
              'statistics_type' => $request['statistics_type'] ?? 'overall',
              'user_overview' => $request['user_overview'] ?? 'overall',
              'business_overview' => $request['business_overview'] ?? 'overall',
          ];
          session()->put('dash_params', $params);
          $data = self::dashboard_data();
          $total_sell = $data['total_sell'];
          $commission = $data['commission'];*/
       // $data['monthly_order_amount'] = OrderPaymentTransaction::NotRefunded()->whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->where('vendor_id',Helper::get_restaurant_id())->sum('order_amount');
        $data['monthly_order_amount'] = Order::where('order_status','delivered')->where('restaurant_id',Helper::get_restaurant_id())->whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->sum('order_amount');


        $data['monthly_user_count'] = DB::table('users')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->where('orders.restaurant_id', Helper::get_restaurant_id())
            ->whereDate('orders.created_at', '>=', $start)
            ->whereDate('orders.created_at', '<=', $end)
            ->groupBy('users.id')
            ->count();
     /* DB::enableQueryLog();
        $data['monthly_user_count'] = User::with(['orders'=>function($query) use($start,$end){
            $query->where('restaurant_id',Helper::get_restaurant_id());
            $query->whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end);
        }])->count();
      $query=  DB::getQueryLog();
      print_r($query); exit;*/
       // $data['monthly_order_count']= OrderPaymentTransaction::whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->where('vendor_id',Helper::get_restaurant_id())->count();
        $data['monthly_order_count']= Order::where('order_status','delivered')->where('restaurant_id',Helper::get_restaurant_id())->whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->count();

        $data['monthly_product_count'] =Food::Active()->where('restaurant_id',Helper::get_restaurant_id())->whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->count();

        $data['last_orders']=Order::with(['restaurant'=>function ($query) {
          //  $query->where('id',Helper::get_restaurant_id());
            $query->with('vendor');},'customer'])->where('restaurant_id',Helper::get_restaurant_id())->whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->limit(6)->get();

        $data['top_products'] = OrderDetail::select('food.name', DB::raw('SUM(order_details.quantity) as total_quantity'))
    ->join('food', 'order_details.food_id', '=', 'food.id')
    ->where('food.restaurant_id', Helper::get_restaurant_id())
    ->groupBy('food.id','food.name')
    ->orderByDesc('total_quantity')
    ->limit(6)
    ->get();/*DB::table('order_details')
    ->join('food', 'order_details.food_id', '=', 'food.id')
    ->join('restaurants', 'food.restaurant_id', '=', 'restaurants.id')
    ->select('order_details.*', DB::raw('COUNT(order_details.food_id) AS food_count'))
    ->whereDate('order_details.created_at', '>=', $start)
    ->whereDate('order_details.created_at', '<=', $end)
    ->where('restaurants.id', Helper::get_restaurant_id())
    ->groupBy('order_details.id') // Replace 'food_id' with 'id'
    ->orderBy('food_count', 'desc')
    ->limit(6)
    ->get();*/
       // dd($data['top_products'] ); exit;
        return view('vendor-views.index', compact('data'));
    }



    public function dashboard_data(Request $request)
    {
//print_r($request->all()); exit;
        $now = Carbon::now();
        $month=$now->month;
        if($request->startDate =='')
            $start=Carbon::now()->format('Y')."-".$month."-".'1';
        else
            $start=$request->startDate;
        if($request->endDate =='')
            $end=Carbon::now()->format('Y-m-d');
        else
            $end=$request->endDate;
        $date1= Carbon::now();



        $month=($date1->month)-1;

        $year= $date1->year;

        $number_days = Carbon::now()->daysInMonth;

        $report=array();

        $i=0;
        for ($currentDate = Carbon::parse($start); $currentDate <= Carbon::parse($end); $currentDate->addDay()) {

            $date= $currentDate;//strtotime($year."-".$month."-".$day);
            //  $date=date('Y-m-d',$estimated);
            $report['order'][$i]=Order::whereDate('created_at',$date)/*->where('order_status','delivered')*/->where('restaurant_id',Helper::get_restaurant_id())->count();
            $report['order_amount'][$i]=(int)Order::whereDate('created_at',$date)/*->where('order_status','delivered')*/->where('restaurant_id',Helper::get_restaurant_id())->sum('order_amount');
            $report['date_format'][$i]= $date->format('Y-m-d');//Carbon::parse($date)->translatedFormat('l j F Y');
            $i++;
        }

        return $report;
    }

}
