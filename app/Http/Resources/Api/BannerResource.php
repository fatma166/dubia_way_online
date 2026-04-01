<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\PopularRestaurantResource;
class BannerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
      //  return parent::toArray($request);
        return [
            'id'=>$this->id,
            'title'=>$this->title??"",
            //'type'=>$this->type??'restaurant_wise',
            'image_url'=>$this->image_url??"",
            "restaurant"=>new PopularRestaurantResource($this->restaurant), //$this->restaurant??"",
            "food"=>$this->food??"",
            "module_place"=>$this->module_place??"",
            "priority"=>$this->priority??""

        ];

    }
}
