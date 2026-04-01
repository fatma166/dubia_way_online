<?php
namespace App\Http\Controllers\Admin;

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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){

        return view('admin-views.index');
    }
    public function dashboard(Request $request)
    {

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

        $data['monthly_order_amount'] = Order::where('order_status','delivered')->whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)/*whereMonth('created_at', date('m'))
                                                ->whereYear('created_at', date('Y'))*/->sum('order_amount');
        $data['monthly_user_count'] = User::whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)/*whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))*/->count();
        $data['monthly_order_count']= Order::where('order_status','delivered')->whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)/*whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))*/->count();
        $data['monthly_vendor_count']=Vendor::whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)/*whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))*/->count();
        $data['top_restaurants'] =Restaurant::Active()->with('compilation')->withCount('orders')

                                            ->orderBy('orders_count', 'desc')
                                            ->limit(6)
                                            ->get();
       /* $data['top_products'] = OrderDetail::with(['food.restaurant'])
            ->select('food_id', DB::raw('COUNT(*) as food_count'))
            ->groupBy('food_id')
            ->orderBy('food_count', 'desc')
            ->limit(6)
            ->get();*/
                $data['top_products'] = OrderDetail::select('food.name', DB::raw('SUM(order_details.quantity) as total_quantity'))
    ->join('food', 'order_details.food_id', '=', 'food.id')
    //->where('food.restaurant_id', Helper::get_restaurant_id())
    ->groupBy('food.id','food.name')
    ->orderByDesc('total_quantity')
    ->limit(6)
    ->get();
     //   dd($data['top_products'] ); exit;
        if ($request->ajax()) {
        return  $data;

        }else {
            return view('admin-views.index', compact('data'));
        }
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
            $report['order'][$i]=Order::whereDate('created_at',$date)/*->where('order_status','delivered')*/->count();
            $report['order_amount'][$i]=(int)Order::whereDate('created_at', $date)/*->where('order_status','delivered')*/->sum('order_amount');
            $report['date_format'][$i]= $date->format('Y-m-d');//Carbon::parse($date)->translatedFormat('l j F Y');
       $i++;
        }

        return $report;
    }
}
