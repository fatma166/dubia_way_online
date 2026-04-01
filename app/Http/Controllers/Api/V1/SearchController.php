<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Modules\Core\HTTPResponseCodes;
use App\Repositories\Api\FoodRepository;
use App\Repositories\Api\RestaurantRepository;
use App\Traits\LocationTrait;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    use LocationTrait;
    public function home_search(Request $request){
        $search_value=$request->search;
        $compilation_id=$request->compilation_id;
        $limit_place= $request->limit_place;
        $offset_place=$request->offset_place;
        $limit_food= $request->limit_food;
        $offset_food=$request->offset_food;
        if($request->filled('type'))
            $type=$request->type;
        if((!$request->filled('zone_id')) && !empty($request['zone_id'])) {
            $zone_ids=array($request['zone_id']);
        }else {
            $data = array('latitude' => $request['lati'], 'longitude' => $request['longi']);
            $zone_ids = $this->get_zone_from_location($data);
        }

        //try {
        $location=[];
        $filter_data=[];
        if($request->filled('lati')&& $request->filled('lati'))
            $location= array('lat' => $request['lati'], 'lng' => $request['longi']);
        if($request->has('compilation_id')&&$compilation_id!=""&&$compilation_id!=null)
            $filter_data=['name'=>$search_value,'compilation_id'=>$compilation_id];
        elseif($request->has('search'))
            $filter_data=['name'=>$search_value];

        $rest=new RestaurantRepository();
        $result=[];
        $result['restaurants']= $rest->get_restaurant($zone_ids,$filter_data,$limit_place,$offset_place,$location);

       // $filter_data_food=['name'=>$search_value,'category_ids'=>$compilation_id];
        $food=new FoodRepository();
        $result['foods']= $food->get_food($zone_ids,"all","all",$limit_food,$offset_food,$location,$filter_data);

        return response()->json([
            'status' => HTTPResponseCodes::Sucess['status'],
            'message'=>HTTPResponseCodes::Sucess['message'],
            'errors' => [],
            'data' => $result,
            'code'=>HTTPResponseCodes::Sucess['code']
        ],HTTPResponseCodes::Sucess['code']);
      //  print_r($result); exit;

    }
   public function home_search2(Request $request){
      // echo "mkjk"; exit;
        $search_value=$request->search;
        $compilation_id=$request->compilation_id;
        $limit_place= $request->limit_place;
        $offset_place=$request->offset_place;
        $limit_food= $request->limit_food;
        $offset_food=$request->offset_food;
        if($request->filled('type'))
            $type=$request->type;
        if((!$request->filled('zone_id')) && !empty($request['zone_id'])) {
            $zone_ids=array($request['zone_id']);
        }else {
            $data = array('latitude' => $request['lati'], 'longitude' => $request['longi']);
            $zone_ids = $this->get_zone_from_location($data);
        }

        //try {
        $location=[];
        $filter_data=[];
        if($request->filled('lati')&& $request->filled('lati'))
            $location= array('lat' => $request['lati'], 'lng' => $request['longi']);
        if($request->has('compilation_id')&&$compilation_id!=""&&$compilation_id!=null){
        
            if($request->has('search')&&$request['search']!=""&&$request['search']!=null)
            $filter_data=['name'=>$search_value,'compilation_id'=>$compilation_id];
            else
             $filter_data=['compilation_id'=>$compilation_id];
        }
        elseif($request->has('search')&&$request['search']!=""&&$request['search']!=null)
            $filter_data=['name'=>$search_value];
//print_r($filter_data); exit;
        $rest=new RestaurantRepository();
      //  $result=[];
        $result= $rest->get_restaurant2($zone_ids,$filter_data,$limit_place,$offset_place,$location);

        // $filter_data_food=['name'=>$search_value,'category_ids'=>$compilation_id];
      /* $food=new FoodRepository();
        $result['foods']= $food->get_food($zone_ids,"all","all",$limit_food,$offset_food,$location,$filter_data);*/

        return response()->json([
            'status' => HTTPResponseCodes::Sucess['status'],
            'message'=>HTTPResponseCodes::Sucess['message'],
            'errors' => [],
            'data' => $result,
            'code'=>HTTPResponseCodes::Sucess['code']
        ],HTTPResponseCodes::Sucess['code']);
        //  print_r($result); exit;

    }
    public function advanced_rest_search(Request $request){
        $filter_data=[];
        if($request->has('high_orders'))
        $filter_data['order_count']='asc';
        if($request->has('high_rate'))
            $filter_data['high_rate']='asc';
        if($request->has('delivery_time'))
            $filter_data['delivery_time']='asc';
        if($request->has('arrange_order'))
            $filter_data['arrange_order']='desc';
        $limit_place= $request->limit_place;
        $offset_place=$request->offset_place;
        if((!$request->filled('zone_id')) && !empty($request['zone_id'])) {
            $zone_ids=array($request['zone_id']);
        }else {
            $data = array('latitude' => $request['lati'], 'longitude' => $request['longi']);
            $zone_ids = $this->get_zone_from_location($data);
        }

        //try {
        $location=[];
        if($request->filled('lati')&& $request->filled('lati'))
            $location= array('lat' => $request['lati'], 'lng' => $request['longi']);
        $rest=new RestaurantRepository();
        $result=[];
        $result= $rest->get_restaurant($zone_ids,$filter_data,$limit_place,$offset_place,$location);
        return response()->json([
            'status' => HTTPResponseCodes::Sucess['status'],
            'message'=>HTTPResponseCodes::Sucess['message'],
            'errors' => [],
            'data' => $result,
            'code'=>HTTPResponseCodes::Sucess['code']
        ],HTTPResponseCodes::Sucess['code']);

    }



}
