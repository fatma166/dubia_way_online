<?php

namespace App\Repositories\Admin\SingleRebo;

//use App\Http\Requests\Admin\CityRequest;


use App\Http\Requests\Admin\CouponRequest;
use App\Models\Compilation;
use App\Models\Coupon;
use App\Repositories\Admin\BaseRepository;
use App\Traits\UploadAttachTrait;
use Illuminate\Http\Request;

class CouponRepository extends BaseRepository
{
    use UploadAttachTrait;

    public function __construct()
    {
        parent::__construct(new Coupon());

    }
    function setDataPayload(Request $request = null, $type = 'store')
    {
        //print_r($request->all()); exit;
        // try {
        if($type=='store'){
            $validate= new CouponRequest() ;

            $data= $request->validate($validate->rules(),[],$validate->attributes());
        }else{
            /*$request_data=$request->all();
            $vendor_id=$request_data['vendor_id'];
            $id=$request_data['id'];
            $validate= new  CouponRequest() ;

            $request = $request->validate($validate->rules());
            $request['vendor_id']=$vendor_id;
            $request['id']=$id;*/
        }

        return($data);
    }
    public function store(Request $request = null, $data = null)
    {
        $data = $this->setDataPayload($request, 'store');

        // $request->image=$images;
       // $request= $request->except(['_token','image']);

        $item = $this->model;
        $item->fill($data);
        $item->save();
        return $item;
    }

    public function update($id, Request $request = null, $data = null)
    {
        $data = $this->setDataPayload($request, 'store');

        $item = $this->model->findOrFail($id);

        $item->fill($data);
        $item->save();
        return $item;
    }

    public function change_status($id,$status){
        $this->model->where('id',$id)->update(['status'=>$status]);
    }




}
