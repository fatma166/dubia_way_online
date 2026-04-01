<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\PopularRestaurantResource;
class GetCountryResource extends JsonResource
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
            'id'=>$this->id_country,
            'name'=>$this->country_name??"",
            //'type'=>$this->type??'restaurant_wise',
            'flag_url'=>asset('flag').'/images/'.$this->flag??"",
            "code"=>$this->code2??""

        ];

    }
}
