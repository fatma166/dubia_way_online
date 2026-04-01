<?php

namespace App\Repositories\Admin\SingleRebo;

use App\Http\Requests\Admin\AdminEmployeeRequest;
use App\Http\Requests\Admin\AdminRoleRequest;
use App\Http\Requests\Admin\BannerRequest;
use App\Http\Requests\Admin\BusinessSettingRequest;
use App\Models\Admin;
use App\Models\AdminRole;
use App\Models\Banner;
use App\Models\BusinessSetting;
use App\Models\Restaurant;
use App\Repositories\Admin\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BusinessSettingRepository extends BaseRepository
{


    public function __construct()
    {
        parent::__construct(new BusinessSetting());

    }
    function setDataPayload(Request $request = null, $type = 'store')
    {
        $validate= new BusinessSettingRequest() ;
        $request= $request->validate($validate->rules(),[],$validate->attributes());
        return($request);
    }
    public function store(Request $request = null, $data = null)
    {
        if ($request != null)
            $data = $this->setDataPayload($request, 'store');
        $check_exist=$this->model->where('key',$data['key'])->first();
        if(!empty($check_exist)){
            return false;
        }
        $request= $request->except(['_token']);
        $item = $this->model;
        $item->fill($request);
        $item->save();
        return $item;
    }

    public function update($id, Request $request = null, $data = null)
    {
        if ($request != null)
            $data = $this->setDataPayload($request, 'store');

       if($request->has('image')) {
           $images = ($this->upload($request->image, 'banner'));
           if(file_exists($request->old_image)){
               unlink($request->old_image);
           }
           unset($request->image);
       }
       if(empty($request['password'])) {
           // $request->image=$images;
           $request = $request->except(['_token','password']);
       }else{

           $request = $request->except(['_token']);
           $request['password']= Hash::make($request['password']);
       }

        if(isset($images[0]))
            $request['image']=$images[0];

     /*   if ($request != null)
            $data = $this->setDataPayload($request, 'update');
*/
        $item = $this->model->findOrFail($id);

        $item->fill($request);
        $item->save();
        return $item;
    }

    public function place_comp($compilation_id){
       $items= Restaurant::where('compilation_id',$compilation_id)->get();
       return($items);
    }




}
