<?php

namespace App\Repositories\Api;
use App\Http\Resources\Api\ListFoodResource;
use App\Interfaces\Api\FoodInterface;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodRepository implements FoodInterface
{
    public function get_food($zone_ids,$restaurant_id,$category_ids,$limit,$offset,$location)
    {

        // TODO: Implement get_food() method.
        $foods = Food::active()
           /* ->whereHas('restaurant', function($q)use($zone_ids,$location){

               // $q->whereIn('zone_id', $zone_ids);
              //  $q->WithLocation($location);
            })*/
           ->when($restaurant_id, function($query) use($restaurant_id){
               return $query->where('restaurant_id', $restaurant_id);
           })
            ->when($category_ids, function($query)use($category_ids){
                $query->whereHas('category',function($q)use($category_ids){
                //   print_r($category_ids); exit;
                    return  $q->where('categories.id',$category_ids)->orWhere('parent_id',$category_ids);
                });
            })

           /* ->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%");
                }
            })*/
            ->paginate($limit, ['*'], 'page', $offset);
        return ListFoodResource::collection($foods);
       /* $data =  [
            'total_size' => $foods->total(),
            'limit' => $limit,
            'offset' => $offset,
            'products' => $foods->items()
        ];*/

        return($data);exit;

    }

    public function single_food($food_id,$related_limit)
    {
        // TODO: Implement single_food() method.
        return  $food= Food::active()->find($food_id);


    }


}
