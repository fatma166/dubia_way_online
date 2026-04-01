<?php

namespace App\Http\Controllers\Vendor;

use App\Models\Order;
use App\Models\User;
use App\Modules\Core\Helper;
use App\Repositories\Admin\Vendor\OrderRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController;
class OrderController extends BaseController
{

    protected $view;
    protected $repository;

    public function __construct(OrderRepository $repository)
    {
        parent::__construct($repository);
        $this->view = 'vendor-views.order';

    }
    public function index(Request $request, $with = [], $withCount = [], $filter = '', $paginate = 10, $whereHas = [])
    {
        $filter_='';
        $users=User::where('active',1)->get();

        if(isset($request->advancedSearch)){
            $status=(isset($request->advancedSearch))?$request->advancedSearch:'all';
            $user_id=(isset($request->advancedSearch))?$request->advancedSearch:'all';
            $phone=(isset($request->advancedSearch))?$request->advancedSearch:'all';
            $restaurant_id=(isset($request->advancedSearch))?$request->advancedSearch:'all';
            $order_amount=(isset($request->advancedSearch))?$request->advancedSearch:'all';
            $created_at=(isset($request->advancedSearch))?$request->advancedSearch:'all';
            $id=(isset($request->advancedSearch))?$request->advancedSearch:'all';
            $request->session()->put('phone', $phone);

            $filter_='order_status|' . $status . '|='.'^user_id|'.$user_id.'|='.'^restaurant_id|'.$restaurant_id.'|='.'^order_amount|'.$order_amount.'|='.'^created_at|'.$created_at.'|='.'^id|'.$id.'|='.'&&restaurant_id|' . Helper::get_restaurant_id(). '|=';

        }elseif(!isset($request->advancedSearch)) {
            $order_status = (isset($request->order_status)) ? $request->order_status : 'all';
            $user_id = (isset($request->user_id)) ? $request->user_id : 'all';
            $from = (isset($request->from)) ? $request->from : 'all';
            $to= (isset($request->to)) ? $request->to : 'all';

            $filter_= 'order_status|' . $order_status . '|=' . '&&user_id|' . $user_id . '|=' .'&&created_at|'.$from.'|>='.'&&created_at|'.$to.'|<='.'&&restaurant_id|' . Helper::get_restaurant_id(). '|=';
        }else{
            $filter_='restaurant_id|' . Helper::get_restaurant_id(). '|=';
        }

        $status=(isset($request->status))?$request->status:'all';
       $orders= parent::index($request, ['restaurant'=>function ($query) {$query->with('vendor');},'customer_address'], [], $filter_, 10, []);  // &&'. 'order_status|' . $status . '|='
//print_r($orders); exit;
       /* if ($request->filled("export_excel") && $request->export_excel == true) {


            foreach ($reviews as $index => $record) {
                $data[$index]['#'] = $index + 1;
                $data[$index]['patient_name'] = optional($record->user)->full_name;
                $data[$index]['doctor_name'] = optional($record->doctor)->full_name;
                $data[$index]['comment'] = $record->comment_text;
                $data[$index]['grade'] = $record->grade;
                $data[$index]['created_at'] = $record->created_at ? Carbon::parse($record->created_at)->format("Y-m-d h:i A"): "";
            }
            $file_name="reviews";
            $headers = ["#", __('patient name'), __('doctor name'), __('comment'), __('grade'), __('date')];
            return  $this->exportList($data,$file_name,$headers);
        }

        */
        if($request->ajax()){
//dd($orders);
            return view($this->view . '.partials._table')->with(compact('orders','users'));
        }

        return view($this->view . '.index', compact('orders','users'));
    }



    public  function details(Request $request,$id){

        $order= parent::index($request,['restaurant','customer_address','details'=>function ($query) use($id) {$query->where('order_id',$id);$query->with('food');},'customer','transaction'=>function ($query) use($id) {$query->where('order_id',$id);}],[],'id|' . $id . '|=','');
        if(isset($order[0]))
        $order=$order[0];
        if ($request->filled("print") && $request->print == true) {
            $print = $request->print;
            return view($this->view . '.invoice', compact('order'));
        }
       return view($this->view . '.details', compact('order'));
    }

    public function change_status(Request $request)
    {
        $status = $request['status'];


        $id = $request['id'];
        $data = $this->repository->change_status($id, $status);

        session()->flash('success', __('updated successfully'));
    }
	public function update_customer_details(Request $request){
       $data= $request['data'];
    // Parse the serialized data into an associative array
    parse_str($data, $output);


        $id = $request['id'];
        $data = $this->repository->update_customer_details($id, $output);

        session()->flash('success', __('updated successfully'));
	}
    public function order_uncheck_count(Request $request){
        $new_order = Order::where(['checked' => 0])->where('restaurant_id',Helper::get_restaurant_id())->count();
        return response()->json([
            'success' => 1,
            'data' => ['new_order' => $new_order]
        ]);
    }

}
