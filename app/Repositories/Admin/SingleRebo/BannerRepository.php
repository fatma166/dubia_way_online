<?php

namespace App\Repositories\Admin\SingleRebo;

use App\Http\Requests\Admin\BannerRequest;
use App\Models\Banner;
use App\Models\Restaurant;
use App\Repositories\Admin\BaseRepository;
use App\Traits\UploadAttachTrait;
use Illuminate\Http\Request;

class BannerRepository extends BaseRepository
{
    use UploadAttachTrait;

    public function __construct()
    {
        parent::__construct(new Banner());

    }
    function setDataPayload(Request $request = null, $type = 'store')
    {

        // try {
        if($type=='store'){
            $validate= new BannerRequest() ;

            $request = $request->validate($validate->rules(),[],$validate->attributes());
        }else{
            $request_data=$request->all();

            $id=$request_data['id'];
            $validate= new BannerRequest() ;

            $request = $request->validate($validate->rules(),[],$validate->attributes());
            $request['id']=$id;
        }
        $data=$request;

        /*if (isset($data['image'])&&!empty($data['image'])) {
            $data['image'] =  $this->upload($data['image'], 'product');
            //unset($data['image']);
        }*/
        return($data);
    }
    public function store(Request $request = null, $data = null)
    {
        if ($request != null)
            $data = $this->setDataPayload($request, 'store');
        if($request->has('image')) {
            $images = ($this->upload($request->image, 'banner'));
            unset($request->image);
        }
        // $request->image=$images;
        $request= $request->except(['_token','image']);

        if(isset($images[0]))
            $request['image']=$images[0];
       /* if ($request != null)
            $data = $this->setDataPayload($request, 'store');*/
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
        // $request->image=$images;
        $request= $request->except(['_token','image','old_image']);

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
