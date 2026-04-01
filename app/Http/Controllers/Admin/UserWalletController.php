<?php

namespace App\Http\Controllers\Admin;
use App\Http\Requests\Admin\ChargeWalletRequest;
use App\Models\User;
use App\Repositories\Admin\SingleRebo\UserWalletRepository;
use Illuminate\Http\Request;


class UserWalletController extends BaseController
{

    protected $view;
    protected $repository;

    public function __construct(UserWalletRepository $repository)
    {
        parent::__construct($repository);
        $this->view = 'admin-views.wallet_customer';

    }
   /* public function index(Request $request, $with = [], $withCount = [], $filter = '', $paginate = 10, $whereHas = [])
    {

       $status=(isset($request->status))?$request->status:'all';
       $orders= parent::index($request, ['restaurant'=>function ($query) {$query->with('vendor');}], [], 'order_status|' . $status . '|=', 10, []);

        return view($this->view . '.index', compact('orders'));
    }



    public  function details(Request $request,$id){

        $order= parent::index($request,['restaurant','customer_address','details'=>function ($query) use($id) {$query->where('order_id',$id);$query->with('food');},'customer','transaction'=>function ($query) use($id) {$query->where('order_id',$id);}],[],'id|' . $id . '|=','');
        if(isset($order[0]))
        $order=$order[0];

       return view($this->view . '.details', compact('order'));
    }
    */
    public function create(){
         $users= User::where('active',1)->get();
        return view($this->view . '.charge', compact('users'));
    }

    public function store_charge_wallet(ChargeWalletRequest $request){

        $user_id=$request->user_id;
        $amount=floatval($request->amount);
        $transaction_type="wallet_charge";
        $referance="";
        $result= $this->repository->store_wallet($user_id, $amount, $transaction_type,$referance);
       if($result== true)
           return back()->with('success',__('user wallet Charged succesfully'));
    }

}
