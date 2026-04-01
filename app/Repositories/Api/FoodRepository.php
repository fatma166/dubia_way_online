<?php

namespace App\Repositories\Api;
use App\Http\Resources\Api\ListFoodResource;
use App\Http\Resources\Api\ListFoodResourceWeb;
use App\Interfaces\Api\FoodInterface;
use App\Models\Food;
use App\Models\FavFood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Modules\Core\Helper;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Api\SingleFoodResource;

class FoodRepository implements FoodInterface
{
    public function get_food($zone_ids,$restaurant_id,$category_ids,$limit,$offset,$location,$filter_data)
    {

        // TODO: Implement get_food() method.
      //  DB::enableQueryLog();
        $paginator= Food::active()
           /* ->whereHas('restaurant', function($q)use($zone_ids,$location){

               // $q->whereIn('zone_id', $zone_ids);
              //  $q->WithLocation($location);
            })*/
             ->with('slider')
          /* ->when($restaurant_id, function($query) use($restaurant_id){
              // if($restaurant_id!="all")
               return $query->where('restaurant_id',config('app.default_vendor'));
           })*/
			->where('restaurant_id',config('app.default_vendor'))
            ->when($category_ids, function($query)use($category_ids) {
                if ($category_ids != "all"){
                    $query->whereHas('category', function ($q) use ($category_ids) {
                        //   print_r($category_ids); exit;
                        return $q->where('categories.id', $category_ids)->orWhere('parent_id', $category_ids);
                    });
                }
            });
        $paginator= $paginator->where(function ($query) use ($filter_data) {
                              if (($filter_data != []) && ($filter_data != "all")) {
                                  foreach ($filter_data as $filter_item => $value) {

                                      if ($filter_item == "compilation_id") {
                                         // echo $value; exit;
                                          $paginator = $query->whereHas('restaurant', function ($q) use ($filter_item, $value) {
                                              //   print_r($category_ids); exit;
                                              return $q->where('restaurants.compilation_id', $value);
                                          });
                                      } elseif($filter_item=="name") {
                                          $paginator = $query->where($filter_item, 'like', '%' . $value . '%');
                                      }
                                      elseif ($filter_item=="except_id") {
                                          $paginator= $query->where('id','!=',$value);
                                      }else
                                      {
                                          $paginator = $query->where($filter_item,$value);
                                      }
                                  }

                              }
                     });

           /* ->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%");
                }
            })*/
        $foods=$paginator->paginate($limit, ['*'], 'page', $offset);

     //  print_r( DB::getQueryLog()); exit;
       //print_r($foods); exit;
        return ListFoodResource::collection($foods);
       /* $data =  [
            'total_size' => $foods->total(),
            'limit' => $limit,
            'offset' => $offset,
            'products' => $foods->items()
        ];*/

     //   return($data);exit;

    }

    public function single_food($food_id,$related_limit)
    {
        // TODO: Implement single_food() method.
        return  $food= Food::active()->with('slider')->find($food_id);


    }

    public function get_popular($filter_data, $limit , $offset,$paginate)
    {
        // TODO: Implement get_popular() method.
        //   DB::enableQueryLog();

        $paginator = Food:: //////////////withcount_orders//////////////Popular()->
            /*->with(['discount'=>function($q){
                return $q->validate();
            }])*/
            where('restaurant_id',config('app.default_vendor'))

            ->Active()
       ////////////////withcount_orders///////////////////// ;$paginator->withCount('orders')

           //////////////withcount_orders/////////////// ->orderBy('orders_count', 'desc');
           ->orderBy('favourite', 'desc');
        if($paginate==true) {
            $result=$paginator->paginate(config('app.web_pagination'));
           // $result=$paginator->get();
          //  print_r($result); exit;
        }else{
            $result=$paginator->limit($limit)
                ->get();
        }

     //   $result1=Helper::food_data_formatting($result, true);
       return ListFoodResourceWeb::collection($result);
        //  $query = DB::getQueryLog();
//print_r($query);exit;
        // ->paginate($limit, ['*'], 'page', $offset);
        /*$paginator->count();*/

    }
	public function get_latest($filter_data, $limit, $offset, $paginate)
{ 
    $paginator = Food::where('restaurant_id', config('app.default_vendor'))
        ->Active()
        ->orderBy('created_at', 'desc'); // Ascending order by created_at

    if ($paginate) {
        $result = $paginator->paginate(config('app.web_pagination'));
    } else {
        $result = $paginator->limit($limit)
            ->offset($offset) // Adding offset if needed
            ->get();
    }
		//print_r($result); exit;

    return ListFoodResourceWeb::collection($result);
}
    public function list_food($filter_data, $limit, $offset, $paginate)
    {
        //  print_r($zone_ids);
        // print_r($location); exit;

        // TODO: Implement get_restaurant() method.

        DB::enableQueryLog();
        $paginator = Food::Active()->where('restaurant_id',config('app.default_vendor'));//->where('restaurant_id',config('app.default_vendor'));
        if (($filter_data != []) && ($filter_data != "all")) {
            foreach ($filter_data as $filter_item => $value) {
                if($filter_item=="name" ) {
                    $paginator = $paginator->where($filter_item, 'like', '%' . $value . '%');
                    //$paginator = $paginator->orwhere('footer_text','like', '%' . $value . '%');
                }
                elseif($filter_item =="notid") {

                    $paginator=$paginator->where('id','!=',$value);
                }
                elseif($filter_item !="order_count"&&$filter_item !="high_rate"&&$filter_item !="arrange_order"&&$filter_item!="price_asc"&&$filter_item!="favourite_desc"&&$filter_item!="price_desc"&&$filter_item!="created_at_desc") {

                    $paginator=$paginator->where($filter_item,$value);
                }
                if($filter_item=='order_count'){
                    $paginator =$paginator->orderBy($filter_item,$value);
                }else if($filter_item=='high_rate'){
					
                    $paginator=$paginator->Rate()->whereNotNull('rating');					

                }else if($filter_item=='arrange_order'){
                    $paginator =$paginator->orderBy('name',$value);
                }elseif($filter_item=='price_asc'){
					//exit;
                    $paginator =$paginator->orderBy('price',$value);
                }elseif($filter_item=='favourite_desc'){
                    $paginator =$paginator->orderBy('favourite',$value);
                }elseif($filter_item=='price_desc'){
                    $paginator =$paginator->orderBy('price',$value);
                }elseif($filter_item=='created_at_desc'){
                    $paginator =$paginator->orderBy('created_at',$value);
                }

            }
        }else{
        $paginator=$paginator->orderBy('created_at','asc');
		}
        if($paginate==true) {
            $result=$paginator->paginate(config('app.web_pagination'));
            // $result=$paginator->get();
            //  print_r($result); exit;
        }else{
            $result=$paginator->limit($limit)
                ->get();
        }
      // print_r( DB::getQueryLog());exit;
        return ListFoodResourceWeb::collection($result);

    }
    
    public function add_fav($request){

        $user_id= Auth::guard('web')->user()->id;
        $product_id=$request->product_id;
       $check_add= FavFood::where(['user_id'=>$user_id,'food_id'=>$product_id])->get()->toArray();

        if($check_add==[]) {

            FavFood::insert(['user_id' => $user_id, 'food_id' => $product_id]);

            return true;
        }else{
            FavFood::where(['user_id' => $user_id, 'food_id' => $product_id])->delete();
            return false;
        }
    }
    
     public function get_user_fav($request)
    {
        // TODO: Implement get_user_fav_restaurant() method.
        $limit=$request->limit?$request->limit:6;
        $offset=$request->offset?$request->offset:0;
        $user_id= Auth::guard('web')->user()->id;
         $data= FavFood::with(['food'=>function ($query) use($user_id) {
            // $query->withOpen();
                 //  ->orderBy('open', 'desc');
         }
         ])->where('user_id',$user_id)->orderBy('id','asc') ->paginate(/*$limit, ['*'], 'page', $offset*/);
     $result=[];
       foreach($data as $dt){
           //print_r($dt->restaurant); exit;
           $result1=Helper::food_data_formatting($dt->food, false);
           $result[]= new SingleFoodResource($result1);
       }
       return $result;
        // return PopularRestaurantResource::collection($data);
    }



}