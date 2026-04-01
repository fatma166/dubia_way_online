<?php

namespace App\Repositories\Admin\Vendor;
use App\Http\Requests\Vendor\CategoryRequest;
use App\Models\Category;
use App\Modules\Core\Helper;
use App\Repositories\Admin\BaseRepository;
use App\Traits\UploadAttachTrait;
use Illuminate\Http\Request;

class CategoryRepository extends BaseRepository
{
    use UploadAttachTrait;

    public function __construct()
    {
        parent::__construct(new Category());

    }
    function setDataPayload(Request $request = null, $type = 'store')
    {

        // try {

        $validate= new CategoryRequest() ;

        $request = $request->validate($validate->rules(),[],$validate->attributes());

        // $data=$request;

        return($request);
    }


    public function store(Request $request = null, $data = null)
    {
        if ($request != null)
            $data= $this->setDataPayload($request, 'store');

        if($request->has('image')) {
            $images = ($this->upload($request->image, 'compilation'));
            unset($request->image);
        }
        // $request->image=$images;
        $request= $request->except(['_token','image']);

        if(isset($images[0]))
            $data['image']=$images[0];
        $data['restaurant_id']=Helper::get_restaurant_id();

       /* if ($request != null)
            $data = $this->setDataPayload($request, 'store');*/
        $item = $this->model;
        $item->fill($data);
        $item->save();
        return $item;
    }

    public function update($id, Request $request = null, $data = null)
    {
        if ($request != null)
            $data= $this->setDataPayload($request, 'store');
       if($request->has('image')) {
           $images = ($this->upload($request->image, 'compilation'));
           unset($request->image);
       }
        // $request->image=$images;
        $request= $request->except(['_token','image']);

        if(isset($images[0]))
            $data['image']=$images[0];
            $data['restaurant_id']=Helper::get_restaurant_id();
     /*   if ($request != null)
            $data = $this->setDataPayload($request, 'update');
*/
        $item = $this->model->findOrFail($id);

        $item->fill($data);
        $item->save();
        return $item;
    }
    public function change_status($id,$status){
        $this->model->where('id',$id)->update(['status'=>$status]);
    }




}
