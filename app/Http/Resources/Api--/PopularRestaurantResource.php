<?php

namespace App\Http\Resources\Api;

use App\Models\Category;
use App\Modules\Core\Helper;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\CategoryResource;
class PopularRestaurantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
      //  if(isset($this->category_ids))
      //      $cats=$this->category_ids;
      //  else
       //     $cats=[];

        return //parent::toArray($request);
        [
            'id'=>$this->id,
            'name'=>$this->name??"",
            'address'=>$this->address??"",
            'phone'=>$this->phone??"",
            'logo'=>$this->logo_url??"",
            'cover_photo_url'=>$this->cover_photo_url??"",
            'footer_text'=>$this->footer_text??"",
            'latitude'=>$this->latitude,
            'longitude'=>$this->longitude,
            'delivery_charge'=>$this->delivery_charge,
             'delivery_time'=>$this->delivery_time,
            'open'=>$this->open,
            'available_time_starts'=>$this->available_time_starts,
            'available_time_ends'=>$this->available_time_ends,
            'vendor_id'=>$this->vendor_id,
            'zone_id'=>$this->zone_id,
            'shipping_coast'=>$this->shipping_coast,
            'avg_rating'=>$this->avg_rating,
            'distance'=>ceil($this->distance),
            'orders_count'=>$this->orders_count??0,
            'rating_count'=>$this->rating_count,
            'distance_time'=>$this->distance_time??0,
            'category_ids'=> CategoryResource::collection(Category::where('restaurant_id',$this->id)->get()),
            'compilation_id'=>$this->compilation_id?? 0
        ];
    }
}
