<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class UserInfoResource extends JsonResource
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
           'f_name'=>$this->f_name,
           'l_name'=>$this->l_name,
            'phone'=>$this->phone,
            'image_url'=>$this->image_url??"",
            'order_count'=>$this->order_count,
            'zone_id'=>$this->zone_id??0,
            'last_login'=>$this->last_login
        ];
    }
}
