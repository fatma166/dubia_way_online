<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class SingleFoodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        exit;
       // return parent::toArray($request);
        if($this->variations!="") {
            foreach (json_decode($this->variations, true) as $var) {
                array_push($variations, [
                    'type' => $var['type'],
                    'price' => (float)$var['price']
                ]);

            }
        }
        return [
            "id"=> $this->id,
            "name"=>$this->name,
            "description"=>$this->description,
            "summary"=>$this->summary,
            "category_id"=>$this->category_id,
            "category_ids"=>$this->category_ids,
            "discount"=> $this->discount??0,
            "discount_type"=>$this->discount?? "percent",
            "restaurant_id"=> $this->restaurant_id,
            "order_count"=> $this->order_count??0,
            "avg_rating"=>$this->avg_rating?? 0,
            "rating_count"=>$this->rating_count?? 0,
            "rating"=>$this->rating??0,
            "product_quantity"=>$this->product_quantity??0,
            "in_stock"=>$this->in_stock,
            "favourite"=>$this->favourite,
            //"image_url"=>$this->image_url,
            "image"=>$this->image,
            "attributes"=>json_decode($this->attributes),
            "choice_options"=>json_decode($this->choice_options),
            "attributes"=>json_decode($this->attributes),
            "variations"=>$variations,

            "slider"=>$this->whenLoaded('slider', function () {
                            return(SliderFoodResource::collection($this->slider)) ;
                        })??[]


        ];
    }
}
