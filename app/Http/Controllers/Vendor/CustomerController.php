<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Compilation;
use App\Models\Zone;

use App\Modules\Core\Helper;
use App\Repositories\Admin\Vendor\CustomerRepository;


use App\Traits\UploadAttachTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController;
use App\Models\Restaurant;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class CustomerController extends BaseController
{

    protected $view;
    protected $repository;

    public function __construct(CustomerRepository $repository)
    {
        parent::__construct($repository);
        $this->view = 'vendor-views.customer';

    }
    public function index(Request $request, $with = [], $withCount = [], $filter = '', $paginate = 10, $whereHas = [])
    {

//=>function ($query) {$query->where('restaurant_id',Helper::get_restaurant_id());}
       $users= parent::index($request,[], ['orders'], '', 10,['orders'=>['restaurant_id'=>Helper::get_restaurant_id()]]);

        return view($this->view . '.index', compact('users'));
    }



    public  function details(Request $request,$id){

       $user= parent::index($request,['orders'=>function ($query) use($id) {$query->with('restaurant');},'addresses'],['orders'],'id|' . $id . '|=','');
        if(isset($user[0]))
        $user=$user[0];
//print_r($user);exit;
       return view($this->view . '.view', compact('user'));
    }
    public function change_status(Request $request)
    {
        $status= $request['status'];

        $id= $request['id'];

        if(isset($request['type']))
            $status= !$status;

         $this->repository->change_status($id,$status);

        session()->flash('success', __('status changed successfully'));
    }

}
