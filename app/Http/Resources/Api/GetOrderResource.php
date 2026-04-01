<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class GetOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       // return parent::toArray($request);
        $dataa=json_decode($this->food_details);

        return [
            'food_id'=>$this->food_id,
           // 'food_details'=>$this->food_details,
            'price'=>$this->price,
            'quantity'=>$this->quantity,
            'food_name'=> $this->whenLoaded('food', function() {
                    return $this->food->name??"";
                }),
            'food_image'=>$this->whenLoaded('food', function() {
                    return asset($this->food->image)??"";
                }),



        ];
    }
}
