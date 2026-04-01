<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FoodRequest;
use App\Http\Requests\Api\SingleFoodRequest;
use App\Modules\Core\HTTPResponseCodes;
use App\Repositories\Api\FoodRepository;
use App\Traits\LocationTrait;


class FoodController extends Controller
{
    use LocationTrait;
    public function get_food(FoodRequest $request)
    {
        $limit= $request->limit;
        $offset=$request->offset;
        $restaurant_id=$request->restaurant_id;
        $category_ids=$request->category_ids;

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
        $food=new FoodRepository();
       $foods= $food->get_food($zone_ids,$restaurant_id,$category_ids,$limit,$offset,$location);
        return response()->json([
            'status' => HTTPResponseCodes::Sucess['status'],
            'message'=>HTTPResponseCodes::Sucess['message'],
            'errors' => [],
            'data' => $foods,
            'code'=>HTTPResponseCodes::Sucess['code']
        ],HTTPResponseCodes::Sucess['code']);


    }

    public function single_food(SingleFoodRequest $request){

        $food_id=$request->food_id;
        $related_limit=$request->related_limit?? 2;

        try {

        $food=new FoodRepository();
       $food= $food->single_food($food_id,$related_limit);
            return response()->json([
                'status' => HTTPResponseCodes::Sucess['status'],
                'message'=>HTTPResponseCodes::Sucess['message'],
                'errors' => [],
                'data' => $food,
                'code'=>HTTPResponseCodes::Sucess['code']
            ],HTTPResponseCodes::Sucess['code']);


    } catch (\Exception $e) {
            return response()->json([
            'status' =>false,
            'errors'=>__('error when retrieve data'),
            'message' =>HTTPResponseCodes::BadRequest['message'],
            'code'=>HTTPResponseCodes::BadRequest['code']
            ],HTTPResponseCodes::Sucess['code']);
            }
    }

}
