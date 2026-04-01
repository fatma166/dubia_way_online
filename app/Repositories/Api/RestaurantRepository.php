<?php

namespace App\Repositories\Api;

use App\Http\Resources\Api\PopularRestaurantResource;
use App\Interfaces\Api\RestaurantInterface;
use App\Models\Category;
use App\Models\FavRestaurant;
use App\Models\Food;
use App\Models\Restaurant;
use App\Modules\Core\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RestaurantRepository implements RestaurantInterface
{
 public function get_restaurant($zone_ids, $filter_data, $limit , $offset, $location)
    {
     //  print_r($zone_ids); 
      // print_r($location); exit;

        // TODO: Implement get_restaurant() method.

      // DB::enableQueryLog();
        $paginator = Restaurant::with('fav')->
                withOpen();
            // ->whereIn('zone_id', $zone_ids)
           if($location!=[])
            $paginator->WithLocation($location);
        $paginator->Active()
            ->where(function ($query) use($zone_ids){
                if($zone_ids != false&&$zone_ids!=""){
                   
               $query->orwhereIn('zone_id', $zone_ids);
               }
            });
            
        
          //  ->type($type)
            /* if($location!=[]) {
            $paginator= $paginator->where(function($query) use($location,$zone_ids){
              
               $query->WithLocation($location);
               if($zone_ids!=false)
                $query->orwhereIn('zone_id', $zone_ids);
            });

        }*/
        if (($filter_data != []) && ($filter_data != "all")) {
            foreach ($filter_data as $filter_item => $value) {
                if($filter_item=="name" ) {
                    $paginator = $paginator->where($filter_item, 'like', '%' . $value . '%');
                    //$paginator = $paginator->orwhere('footer_text','like', '%' . $value . '%');
                }
                elseif($filter_item !="order_count"&&$filter_item !="high_rate"&&$filter_item !="delivery_time"&&$filter_item !="arrange_order") {
                    
                    $paginator=$paginator->where($filter_item,$value);
                }
                if($filter_item=='order_count'){
                    $paginator =$paginator->orderBy($filter_item,$value);
                }else if($filter_item=='high_rate'){
                    $paginator =$paginator->Rate();

                }else if($filter_item=='delivery_time'){
                    $paginator =$paginator->orderBy($filter_item,$value);
                }else if($filter_item=='arrange_order'){
                    $paginator =$paginator->orderBy('name',$value);
                }

            }
        }
         /* whereHas(function ($query) use($location){
              if($location['lat'] !== null && $location['lng'] !== null){

                  //$query->whereHas('address', function($query) use ($data) {

                  //  });
              }
          })*/
           // ->where('distance','<',10)
            //->orderBy('distance', 'desc')
           // ->orderBy('open', 'desc')
        $paginator=$paginator->orderBy('created_at', 'desc');
          $paginator1=  $paginator->paginate($limit, ['*'], 'page', $offset);
            // $query= DB::getQueryLog();
    // print_r($query); exit;
//print_r($paginator1); exit;
        $result1=Helper::restaurant_data_formatting($paginator1,true);
       //  $query= DB::getQueryLog();
      //print_r($query); exit;
       // if(count($paginator->items())==0)
         //   return [];
        /*$paginator->count();*/
        return PopularRestaurantResource::collection($result1);
       /* return [
            'total_size' => $paginator1->total(),
            'limit' => $limit,
            'offset' => $offset,
            'restaurants' => $paginator1->items()
        ];*/
    }
    public function get_restaurant2($zone_ids, $filter_data, $limit , $offset, $location)
    {
        

        // TODO: Implement get_restaurant() method.

       // DB::enableQueryLog();
        $paginator = Restaurant::with('fav')->
            withOpen()
           /* ->where(function ($query) use($location,$zone_ids){
                if($zone_ids != false)
               $query->whereIn('zone_id', $zone_ids);
               else
                $query->WithLocation($location);
            })*/
            ->Active()
            ->WithLocation($location)
            ->where(function ($query) use($zone_ids){
                if($zone_ids != false&&$zone_ids!=""){
                   
               $query->orwhereIn('zone_id', $zone_ids);
               }
            });
            if((isset($filter_data['compilation_id']))&& ($filter_data['compilation_id']!="" ) && ($filter_data['compilation_id']!=null)) {
                        $paginator= $paginator->where('compilation_id',$filter_data['compilation_id']);
                    }
          //  ->type($type)
       
            if (($filter_data != []) && ($filter_data != "all")) {
                foreach ($filter_data as $filter_item => $value) {
                    if($filter_item=="name") {
                        $paginator = $paginator->where($filter_item, 'like', '%' . $value . '%');
                       // $paginator = $paginator->orwhere('footer_text','like', '%' . $value . '%');
                         $paginator  =$paginator->with(['foods'=>function($query) use($value){
                              $query->orwhere('name', 'like', '%' . $value . '%');
                              
                         
                         }]);
                        /* $paginator=$paginator->orWhereHas('foods', function ($query) use ($value) {
                               $query->where('name', 'like', '%' . $value . '%');
                         });*/
                         
                    }else if($filter_item=='order_count'){
                        $paginator =$paginator->orderBy($filter_item,$value);
                    }else if($filter_item=='high_rate'){
                        $paginator =$paginator->Rate();

                    }else if($filter_item=='delivery_time'){
                        $paginator =$paginator->orderBy($filter_item,$value);
                    }else if($filter_item=='arrange_order'){
                        $paginator =$paginator->orderBy('name',$value);
                    }
                         else if(($filter_item=="compilation_id")&&$filter_item!=""&&$filter_item!=null) {
                        $paginator = $paginator->where($filter_item, $value);
                    }

                }
            }
            /* if($location!=[]) {
             $paginator->where(function($query) use($location,$zone_ids){
              
               $query->WithLocation($location);
               if($zone_ids!=false)
                $query->orwhereIn('zone_id', $zone_ids);
            });*/

        /*  //  $paginator = $paginator->WithLocation($location);

        }else{
            if($zone_ids!=false)
           
           $paginator->whereIn('zone_id', $zone_ids);*/
       // }
         /* whereHas(function ($query) use($location){
              if($location['lat'] !== null && $location['lng'] !== null){

                  //$query->whereHas('address', function($query) use ($data) {

                  //  });
              }
          })*/
           // ->where('distance','<',10)
            //->orderBy('distance', 'desc')
           // ->orderBy('open', 'desc')
        $paginator=$paginator->orderBy('created_at', 'desc');
          $paginator1=  $paginator->paginate($limit, ['*'], 'page', $offset);
          //   $query= DB::getQueryLog();
     //print_r($query); exit;
//print_r($paginator1); exit;
        $result1=Helper::restaurant_data_formatting($paginator1,true);
//print_r($result1); exit;
       // if(count($paginator->items())==0)
         //   return [];
        /*$paginator->count();*/
        return PopularRestaurantResource::collection($result1);
       /* return [
            'total_size' => $paginator1->total(),
            'limit' => $limit,
            'offset' => $offset,
            'restaurants' => $paginator1->items()
        ];*/
    }

    public function get_popular($zone_ids,$filter_data, $limit , $offset,$location)
    {
        // TODO: Implement get_popular() method.
     //   DB::enableQueryLog();
        $paginator = Restaurant::withOpen()
            /*->with(['discount'=>function($q){
                return $q->validate();
            }])*/->where(function($query) use($location,$zone_ids){
               if($location!=[])
               $query->WithLocation($location);
               if($zone_ids!=false)
                $query->orwhereIn('zone_id', $zone_ids);
            })
//whereIn('zone_id', $zone_ids)

            ->Active();
        if($location!=[])
            $paginator->WithLocation($location);
           $result= $paginator->withCount('orders')
            ->orderBy('open', 'desc')
            ->orderBy('orders_count', 'desc')
            ->limit($limit)
            ->get();
        $result1=Helper::restaurant_data_formatting($result, true);
        return  PopularRestaurantResource::collection($result1);
      //  $query = DB::getQueryLog();
//print_r($query);exit;
        // ->paginate($limit, ['*'], 'page', $offset);
        /*$paginator->count();*/

    }
    public  function get_details($id)
    {
        // TODO: Implement get_details() method.
        $restaurant= Restaurant::with([/*'discount'=>function($q){
            return $q->validate();
        }, 'campaigns',*/ 'schedules'])->withOpen()->active()->whereId($id)->first();

        if($restaurant)
        {

            DB::enableQueryLog();
            $category_ids = DB::table('food')
                ->join('categories', 'food.category_id', '=', 'categories.id')
                ->selectRaw('IF((categories.position = "0"), categories.id, categories.parent_id) as categories')
                ->where('food.restaurant_id', $id)
                ->where('categories.status',1)
                ->groupBy('categories')
                ->get();

             //dd($category_ids->pluck('categories'));
            $restaurant = Helper::restaurant_data_formatting($restaurant);
            $restaurant['category_ids'] = array_map('intval', $category_ids->pluck('categories')->toArray());

        }
       // return($restaurant);
        return new PopularRestaurantResource($restaurant);
    }

    public function get_latest($zone_ids,$filter_data,$limit,$location)
    {

        // TODO: Implement get_latest() method.
        DB::enableQueryLog();
        $restaurants= Restaurant::
        //   withOpen()
       // whereIn('zone_id', $zone_ids)
       where(function($query) use($location,$zone_ids){
              
               $query->WithLocation($location);
               if($zone_ids!=false)
                $query->orwhereIn('zone_id', $zone_ids);
            })
            ->Active()
            //  ->type($type)
            ->WithLocation($location)
            /* whereHas(function ($query) use($location){
                 if($location['lat'] !== null && $location['lng'] !== null){

                     //$query->whereHas('address', function($query) use ($data) {

                     //  });
                 }
             })*/
            // ->where('distance','<',10)
            ->limit($limit)
            ->orderBy('created_at', 'desc')
            // ->orderBy('open', 'desc')

            ->get();

            return($restaurants);
    }
    public function get_user_fav_restaurant($request)
    {
        // TODO: Implement get_user_fav_restaurant() method.
        $limit=$request->limit?$request->limit:6;
        $offset=$request->offset?$request->offset:0;
        $user_id= Auth::guard('api')->user()->id;
         $data= FavRestaurant::with(['restaurant'=>function ($query) use($user_id) {
             $query->withOpen();
                 //  ->orderBy('open', 'desc');
         }
         ])->where('user_id',$user_id)->orderBy('id','asc') ->paginate($limit, ['*'], 'page', $offset);
     $result=[];
       foreach($data as $dt){
           //print_r($dt->restaurant); exit;
           $result1=Helper::restaurant_data_formatting($dt->restaurant, false);
           $result[]= new PopularRestaurantResource($result1);
       }
       return $result;
        // return PopularRestaurantResource::collection($data);
    }


       public function add_fav_restaurant($request){

        $user_id= Auth::guard('api')->user()->id;
        $restaurant_id=$request->restaurant_id;
       $check_add= FavRestaurant::where(['user_id'=>$user_id,'restaurant_id'=>$restaurant_id])->get()->toArray();

        if($check_add==[]) {

            FavRestaurant::insert(['user_id' => $user_id, 'restaurant_id' => $restaurant_id]);

            return true;
        }else{
            FavRestaurant::where(['user_id' => $user_id, 'restaurant_id' => $restaurant_id])->delete();
            return false;
        }
    }
    
      public function get_selected_restaurant($request)
    {
        // TODO: Implement get_user_fav_restaurant() method.
        $limit=$request->limit?$request->limit:6;
        $offset=$request->offset?$request->offset:0;

        $data= Restaurant::withOpen()->where('selected_admin',1)->orderBy('id','asc') ->paginate($limit, ['*'], 'page', $offset);
        $result=[];
        foreach($data as $dt){
           // print_r($dt); exit;
            $result1=Helper::restaurant_data_formatting($dt, false);
            $result[]= new PopularRestaurantResource($result1);
        }
        return $result;
        // return PopularRestaurantResource::collection($data);
    }


}
