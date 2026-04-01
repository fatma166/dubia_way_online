<?php

namespace App\Repositories\Admin\SingleRebo;

use App\Http\Requests\Admin\BannerRequest;
use App\Http\Requests\Admin\NotificationRequest;
use App\Models\Banner;
use App\Models\Notification;
use App\Models\Restaurant;
use App\Modules\Core\Helper;
use App\Repositories\Admin\BaseRepository;
use App\Services\FCMService;
use App\Traits\UploadAttachTrait;
use Illuminate\Http\Request;

class NotificationRepository extends BaseRepository
{
    use UploadAttachTrait;

    public function __construct()
    {
        parent::__construct(new Notification());

    }
    function setDataPayload(Request $request = null, $type = 'store')
    {

        // try {
       // if($type=='store'){
            $validate= new NotificationRequest();

            $request= $request->validate($validate->rules(),[],$validate->attributes());

        /*}else{
            $request_data=$request->all();

            $id=$request_data['id'];
            $validate= new NotificationRequest();

            $request = $request->validate($validate->rules(),[],$validate->attributes());
            $request['id']=$id;
        }*/
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
            $images = ($this->upload($request->image, 'notification'));
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
 $request['zone_id']='all';
        $topic_all_zone=[
            'customer'=>'all_zone_customer',
            'vendor'=>'all_zone_vendor',
        ];
        

        $topic_zone_wise=[
            'customer'=>'zone_'.$request['zone_id'].'_customer',
            'vendor'=>'zone_'.$request['zone_id'].'_vendor',
        ];
       
        $topic =( $request['zone_id']== 'all')?$topic_all_zone[$request['target']]:$topic_zone_wise[$request['target']];
        if(isset($request['image']))
        {
            $request['image']= asset($request['image']);
        }
        FCMService::send_push_notif_to_topic($request,$topic,'notify');
        return $item;
    }

    public function update($id, Request $request = null, $data = null)
    {
        if ($request != null)
            $data = $this->setDataPayload($request, 'store');
if(isset($request->old_image))
    $old_img=asset($request->old_image);
       if($request->has('image')) {
           $images = ($this->upload($request->image, 'notification'));
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
          $request['zone_id']='all';
        $topic_all_zone=[
            'customer'=>'all_zone_customer',
            'vendor'=>'all_zone_vendor',
        ];

        $topic_zone_wise=[
            'customer'=>'zone_'.$request['zone_id'].'_customer',
            'vendor'=>'zone_'.$request['zone_id'].'_vendor',
        ];
      
        $topic =( $request['zone_id']== 'all')?$topic_all_zone[$request['target']]:$topic_zone_wise[$request['target']];
        if(isset($request['image']))
        {
            $request['image']= asset($request['image']);
        }else{
            $request['image']= $old_img;
        }
        FCMService::send_push_notif_to_topic($request,$topic,'notify');
        return $item;
    }

    public function place_comp($compilation_id){
       $items= Restaurant::where('compilation_id',$compilation_id)->get();
       return($items);
    }




}
