<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return       [
            'id'=>$this->id,
            'contact_person_number'=>$this->contact_person_number ?? "",
            'address'=>$this->address??"",
            'latitude'=>$this->latitude??"",
            'longitude'=>$this->longitude ??"",
            'user_id'=>$this->user_id,
            'floor'=>$this->floor??"",
            'road'=>$this->road??"",
            'house'=>$this->house??"",
            'zone_id'=>$this->zone_id??0,
        ];

    }
}
