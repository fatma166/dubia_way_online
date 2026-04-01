<?php

namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FavRestautantRequest;
use App\Http\Requests\Api\LatestRestaurantRequest;
use App\Http\Requests\Api\PopularRestaurantRequest;
use App\Http\Resources\Api\PopularRestaurantResource;
use App\Modules\Core\Helper;
use App\Modules\Core\HTTPResponseCodes;
use App\Repositories\Api\RestaurantRepository;
use App\Traits\LocationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
    use LocationTrait;
    public function list_rest(LatestRestaurantRequest $request, $filter_data="all")
    {
       $limit= $request->limit;
       $offset=$request->offset;
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
           if($request->filled('lati')&& $request->filled('lati'))
                $location= array('lat' => $request['lati'], 'lng' => $request['longi']);

            $filter_data=['compilation_id'=>$request->compilation_id];
            $rest=new RestaurantRepository();
            $restaurants = $rest->get_restaurant($zone_ids,$filter_data,$limit,$offset,$location);

          /*    if(count($restaurants)!=0)
            $restaurants['restaurants'] = Helper::restaurant_data_formatting($restaurants['restaurants'], true);
*/
            return response()->json([
                'status' => HTTPResponseCodes::Sucess['status'],
                'message'=>HTTPResponseCodes::Sucess['message'],
                'errors' => [],
                'data' =>  $restaurants,
                'code'=>HTTPResponseCodes::Sucess['code']
            ],HTTPResponseCodes::Sucess['code']);

       /* } catch (\Exception $e) {
            return response()->json([
                'status' =>false,
                'errors'=>__('error when retrieve data'),
                'message' =>HTTPResponseCodes::BadRequest['message'],
                'code'=>HTTPResponseCodes::BadRequest['code']
            ],HTTPResponseCodes::Sucess['code']);
        }*/
    }

    public function get_popular_restaurants(PopularRestaurantRequest $request,$filter_data='')
    {
        $limit= $request->limit;
        $offset=$request->offset;
        if((!$request->filled('zone_id')) && !empty($request['zone_id'])) {
            $zone_ids=array($request['zone_id']);
        }else {
            $data = array('latitude' => $request['lati'], 'longitude' => $request['longi']);
            $zone_ids = $this->get_zone_from_location($data);
        }
       // try {
            $location=[];
            if($request->filled('lati')&& $request->filled('lati'))
                $location= array('lat' => $request['lati'], 'lng' => $request['longi']);
            $rest=new RestaurantRepository();
            $restaurants = $rest->get_popular($zone_ids,$filter_data,$limit,$offset,$location);

            return response()->json([
                'status' => HTTPResponseCodes::Sucess['status'],
                'message'=>HTTPResponseCodes::Sucess['message'],
                'errors' => [],
                'data' =>  $restaurants,
                'code'=>HTTPResponseCodes::Sucess['code']
            ],HTTPResponseCodes::Sucess['code']);

       /* } catch (\Exception $e) {
            return response()->json([
                'status' =>false,
                'errors'=>__('error when retrieve data'),
                'message' =>HTTPResponseCodes::BadRequest['message'],
                'code'=>HTTPResponseCodes::BadRequest['code']
            ],HTTPResponseCodes::Sucess['code']);
        }*/


    }
    public function get_details($id)
    {
      //  try {
            $rest=new RestaurantRepository();
            $restaurants = $rest->get_details($id);
            return response()->json([
                'status' => HTTPResponseCodes::Sucess['status'],
                'message'=>HTTPResponseCodes::Sucess['message'],
                'errors' => [],
                'data' =>  $restaurants,
                'code'=>HTTPResponseCodes::Sucess['code']
            ],HTTPResponseCodes::Sucess['code']);

      /*  } catch (\Exception $e) {
            return response()->json([
                'status' =>false,
                'errors'=>__('error when retrieve data'),
                'message' =>HTTPResponseCodes::BadRequest['message'],
                'code'=>HTTPResponseCodes::BadRequest['code']
            ],HTTPResponseCodes::Sucess['code']);
        }*/

    }

    public function get_latest(LatestRestaurantRequest $request ,$filter_data="all"){

        $limit= $request->limit;
        $offset= $request->offset;

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
        $restaurants = $rest->get_restaurant($zone_ids,$filter_data,$offset,$limit,$location);

        if(count($restaurants)!=0)
            $restaurants['restaurants'] = Helper::restaurant_data_formatting($restaurants['restaurants'], true);

        return response()->json([
            'status' => HTTPResponseCodes::Sucess['status'],
            'message'=>HTTPResponseCodes::Sucess['message'],
            'errors' => [],
            'data' =>  $restaurants,
            'code'=>HTTPResponseCodes::Sucess['code']
        ],HTTPResponseCodes::Sucess['code']);

        /* } catch (\Exception $e) {
             return response()->json([
                 'status' =>false,
                 'errors'=>__('error when retrieve data'),
                 'message' =>HTTPResponseCodes::BadRequest['message'],
                 'code'=>HTTPResponseCodes::BadRequest['code']
             ],HTTPResponseCodes::Sucess['code']);
         }*/
    }

    public function get_user_fav_restaurant(Request $request){

        $rest=new RestaurantRepository();
        $restaurants = $rest->get_user_fav_restaurant($request);
        return response()->json([
            'status' => HTTPResponseCodes::Sucess['status'],
            'message'=>HTTPResponseCodes::Sucess['message'],
            'errors' => [],
            'data' => $restaurants,
            'code'=>HTTPResponseCodes::Sucess['code']
        ],HTTPResponseCodes::Sucess['code']);
    }
    public function add_fav_restaurant(FavRestautantRequest $request){

        $rest=new RestaurantRepository();
        $return1= $rest->add_fav_restaurant($request);
        if($return1==false){
            return response()->json([
                'status' =>false,
                'errors'=>__('added_before'),
                'message' =>__('added_before'),
                'code'=>HTTPResponseCodes::BadRequest['code']
            ],HTTPResponseCodes::Sucess['code']);
        }
        return response()->json([
            'status' => HTTPResponseCodes::Sucess['status'],
            'message'=>HTTPResponseCodes::Sucess['message'],
            'errors' => [],
            'data' => [],
            'code'=>HTTPResponseCodes::Sucess['code']
        ],HTTPResponseCodes::Sucess['code']);
    }
}

