<?php

namespace App\Repositories\Admin\SingleRebo;
use App\Http\Requests\Admin\PlaceEditRequest;
use App\Http\Requests\Admin\PlaceRequest;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\RestaurantWallet;
use App\Models\Review;
use App\Models\Vendor;
use App\Models\WithdrawRequest;
use App\Modules\Core\Helper;
use App\Repositories\Admin\BaseRepository;
use App\Traits\UploadAttachTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PlaceRepository extends BaseRepository
{
    use UploadAttachTrait;

    public function __construct()
    {
        parent::__construct(new Restaurant());

    }
    function setDataPayload(Request $request = null, $type = 'store')
    {
        //print_r($request->all()); exit;
       // try {
        if($type=='store'){
            $validate= new PlaceRequest() ;

            $request = $request->validate($validate->rules(),[],$validate->attributes());
        }else{
            $request_data=$request->all();
            $vendor_id=$request_data['vendor_id'];
            $id=$request_data['id'];
            $validate= new PlaceEditRequest() ;

            $request = $request->validate($validate->rules(),[],$validate->attributes());
            $request['vendor_id']=$vendor_id;
            $request['id']=$id;
        }



       /* }catch(\Exception $e){
            print_r($e->errors());
        }*/
       $request['delivery_time']=$request['delivery_time_from']."-".$request['delivery_time_to'];
        unset($request['delivery_time_from']); unset($request['delivery_time_to']);
      //  $data = $request->except('image','cover_photo', '_token','delivery_time_from','delivery_time_to');
       $data=$request;

        if (isset($data['image'])&&!empty($data['image'])) {
            $data['logo'] =  $this->upload($data['image'], 'place');
            unset($data['image']);
        }
        if (isset($data['cover_photo'])&&!empty($data['cover_photo'])) {
           $cover=  $this->upload($data['cover_photo'], 'place');
            unset($data['cover_photo']);
            $data['cover_photo'] =$cover;
        }

        return($data);
    }

    public function store(Request $request = null, $data = null)
    {

       if ($request != null)
            $data = $this->setDataPayload($request, 'store');
            $transaction= DB::transaction(function () use ($data) {
            $data_vendor=array('f_name'=>$data['f_name'],'l_name'=>$data['l_name'],'phone'=>$data['phone'],'email'=>$data['email'],'password'=> Hash::make($data['password']));
            unset($data['f_name']);
            unset($data['l_name']);
           // unset($data['email']);
         //   unset($data['phone']);
            unset($data['confirm_password']);

            $vendor_id= Vendor::insertGetId($data_vendor);
//print_r($vendor_id); exit;

            $data['vendor_id']=$vendor_id;
            if(isset($data['logo'][0]))
                 $data['logo']=$data['logo'][0];
            if(isset($data['cover_photo'][0]))
                 $data['cover_photo']=$data['cover_photo'][0];
            $item = $this->model;
            $item->fill($data);
            $item->save();
           return $item;
        });

        if ($transaction) {
            return $transaction;
        }

        return back()->with(["error" => __("something went wrong please try again")]);




    }

    public function update($id, Request $request = null, $data = null)
    {
       // print_R($request->all()); exit;
        if ($request != null)
            $data = $this->setDataPayload($request, 'update');
      
        $transaction= DB::transaction(function () use ($data) {
            if($data['password']!=null)
            $data_vendor=array('f_name'=>$data['f_name'],'l_name'=>$data['l_name'],'phone'=>$data['phone'],'email'=>$data['email'],'password'=> Hash::make($data['password']));
          else
              $data_vendor=array('f_name'=>$data['f_name'],'l_name'=>$data['l_name'],'phone'=>$data['phone'],'email'=>$data['email']);
            unset($data['f_name']);
            unset($data['l_name']);
          //  unset($data['email']);
          //  unset($data['phone']);
            unset($data['confirm_password']);


            Vendor::where('id',$data['vendor_id'])->update($data_vendor);
//print_r($vendor_id); exit;

           // $data['vendor_id']=$vendor_id;
            if(isset($data['logo'][0]))
            $data['logo']=$data['logo'][0];
            if(isset($data['cover_photo'][0]))
            $data['cover_photo']=$data['cover_photo'][0];

            $item = $this->model;
           
            $item = $item::find($data['id']);
            unset($data['id']);
            $item->fill($data);
          //  print_r($data['delivery_time_unit']); exit;
            $item->save();
             //print_r($items); exit;
            return $item;
        });

        if ($transaction) {
            return $transaction;
        }

        return back()->with(["error" => __("something went wrong please try again")]);


////////////////////////////////////
       if($request->has('image')) {
           $images = ($this->upload($request->image, 'compilation'));
           unset($request->image);
       }
        // $request->image=$images;
        $request= $request->except(['_token','image']);

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


    public function delete($id)
    {

        return parent::delete($id); // TODO: Change the autogenerated stub
    }
    public function statistics(){
        $currentDate = Carbon::now();
        $nowDate = $currentDate->subDays($currentDate->dayOfWeek + 1);
         $data['place_count']=  $this->model->count();
         $data['place_inactive_count']=  $this->model->where('status',0)->count();
         $data['place_active_count']=  $this->model->where('status',1)->count();
         $data['place_recent_count']=  $this->model->whereDate('created_at','>',$nowDate)->count();
         return $data;

    }

    public function details($id){
       
         $data['order_amounts']=Order::where(['restaurant_id'=>$id,'order_status'=>'delivered'])->sum('order_amount');
         $data['order_count']=Order::where(['restaurant_id'=>$id,'order_status'=>'delivered'])->count();

          $data['place']= parent::show($id,['vendor','compilation'],['orders']);
          //dd($data); exit;
          $data['orders']= Order::where('restaurant_id',$id)->with('customer')->paginate(config('default_pagination'));
             
          $data['reviews']=Review::with(['customer','order'=>function ($query) use ($id){
                                           $query->where('restaurant_id',$id);
                                        }])->whereHas('order',function ($query) use ($id){
              $query->where('restaurant_id',$id);
          })->paginate(config('default_pagination'));
        
          $data['withdraw']= WithdrawRequest::where('vendor_id',$data['place']['vendor_id'])->with('vendor')->addSelect( DB::raw('SUM(amount) AS withdraw_amount'))->get();
          $data['wallet']=RestaurantWallet::where('vendor_id',$data['place']['vendor_id'])->get();
          $data['evaluation']=Helper::calculate_restaurant_rating($data['place']['rating']);
//print_r($data); exit;
          return($data);

    }
    public function change_status($id,$status){
        $this->model->where('id',$id)->update(['status'=>$status]);
    }

    public function fav_status($id,$status){
        $this->model->where('id',$id)->update(['selected_admin'=>$status]);

    }

}
