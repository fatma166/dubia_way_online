<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ListFoodResource+ extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return //parent::toArray($request);
        [
            'id'=>$this->id,
            'name'=>$this->name??"",
            'description'=>$this->description??"",
            'image_url'=>$this->image_url??"",
            'category_id'=>$this->category_id??"",
            'variations'=>$this->variations??[],
            'choice_options'=>$this->choice_options??[],
            'price'=>$this->price??0,
            'restaurant_id'=>$this->restaurant_id,
            'order_count'=>$this->order_count,
            'avg_rating'=>$this->avg_rating,
            'rating_count'=>$this->rating_count







        ];
    }
}
