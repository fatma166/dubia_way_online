<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Admin\SingleRebo\CustomerRepository;

use Illuminate\Http\Request;


class CustomerController extends BaseController
{

    protected $view;
    protected $repository;

    public function __construct(CustomerRepository $repository)
    {
        parent::__construct($repository);
        $this->view = 'admin-views.customer';

    }
    public function index(Request $request, $with = [], $withCount = [], $filter = '', $paginate = 10, $whereHas = [])
    {


       $users= parent::index($request,[], ['orders'], '', 10, []);

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
        if($request['status']=="")$status=0;
        $id= $request['id'];

        if(isset($request['type']))
            $status= !$status;
        $data= $this->repository->change_status($id,$status);

        return back()->with('success','Copoun Status Changed succesfully');
    }
    
    public function delete($id){
        parent::destroy($id);
        return redirect(route('admin.customer.index'));

    }
}
