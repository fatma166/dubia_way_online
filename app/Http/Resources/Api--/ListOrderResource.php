<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ListOrderResource extends JsonResource
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
        return [
            'order_id'=>$this->id,
            'user_id'=>$this->user_id,
            'order_amount'=>$this->order_amount,
            'order_status'=>$this->order_status,
            'delivery_address_id'=>$this->delivery_address_id??0,
            'accepted'=>$this->accepted??"00:00:00",
            'confirmed'=>$this->confirmed??"00:00:00",
            'delivered'=>$this->delivered??"00:00:00",
            'picked_up'=>$this->picked_up??"00:00:00",
            'processing_time'=>$this->processing_time??"00",
            'restaurant_id'=>$this->restaurant->id,
             'restaurant_name'=>$this->restaurant->name,
            'phone'=>$this->restaurant->phone,
            'logo_url'=>$this->restaurant->logo_url,
            'cover_url'=>$this->restaurant->cover_photo_url??"",
            'address'=>$this->restaurant->address,
            'latitude'=>$this->restaurant->latitude,
            'longitude'=>$this->restaurant->longitude,
            'footer_text'=>$this->restaurant->footer_text??"",
            'details_count'=>$this->details_count,

        ];
    }
}
