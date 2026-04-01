<?php

namespace App\Http\Controllers\Api\V1;

use App\CentralLogics\CategoryLogic;
use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CategoryRequest;
use App\Http\Requests\Api\ReviewRequest;
use App\Http\Requests\Api\SingleFoodRequest;
use App\Http\Requests\Api\SingleResaurantRequest;
use App\Models\Category;
use App\Modules\Core\HTTPResponseCodes;
use App\Repositories\Api\CategoryRepository;
use App\Repositories\Api\ReviewRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{

    public function review(ReviewRequest $request){
        try {
            $review=new ReviewRepository();
            $review= $review->review($request->restaurant_id);
            return response()->json([
                'status' => HTTPResponseCodes::Sucess['status'],
                'message'=>HTTPResponseCodes::Sucess['message'],
                'errors' => [],
                'data' => $review,
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

    public function add_food_review(SingleFoodRequest $request){

    }
    public function add_restaurant_review(ReviewRequest $request){
        try {
            $rev_obj = new ReviewRepository();
            $rev_obj->add_restaurant_review($request);
            return response()->json([
                'status' => HTTPResponseCodes::Sucess['status'],
                'message'=>HTTPResponseCodes::Sucess['message'],
                'errors' => [],
                'data' => [],
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
    public function get_restaurant_review(SingleResaurantRequest $request){
       try{
        $review_obj=new ReviewRepository();
       $cal_data= $review_obj->get_restaurant_review($request);
        return response()->json([
            'status' => HTTPResponseCodes::Sucess['status'],
            'message'=>HTTPResponseCodes::Sucess['message'],
            'errors' => [],
            'data' => $cal_data,
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
