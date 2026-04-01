<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ListFoodResourceWeb extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        if($this->discount_type=="percent"){ $price_after=$this->price-($this->price*$this->discount/100); }else{$price_after=$this->price-$this->discount;}
        return //parent::toArray($request);
            [
                'id'=>$this->id,
                'name'=>$this->name??"",
                'description'=>Str::limit(strip_tags($this->description))??"",
                'image_url'=>$this->image_url??"",
                'category_id'=>$this->category_id??"",
                'variations'=>$this->variations??[],
                'choice_options'=>$this->choice_options??[],
                'price'=>$this->price??0,
                'restaurant_id'=>$this->restaurant_id,
                'order_count'=>$this->order_count,
                'avg_rating'=>$this->avg_rating,
                'rating_count'=>$this->rating_count,
                'discount'=> $this->discount,
                'discount_type'=> $this->discount_type,
                'price_after_discount'=>$price_after,
                'in_stock'=>$this->in_stock,
                'product_quantity'=>$this->product_quantity,
                'slider'=>$this->whenLoaded('slider', function () {
                        return(SliderFoodResource::collection($this->slider)) ;
                    })??[]










            ];
    }
}
