<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\PopularRestaurantResource;
class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
      // parent::toArray($request);
        
        $dataa=$this->created_At;
        if(date('d M Y',strtotime($this->created_at))==date('d M Y')) { $dataa= date('H:i',strtotime($this->created_at));} elseif(date('Y',strtotime($this->created_at))!= date('Y')) { $dataa= date('d M Y',strtotime($this->created_at)). date('H:i',strtotime($this->created_at));}
        else { $dataa =date('d M',strtotime($this->created_at)) . date('H:i',strtotime($this->created_at)) ;}

        return [
            'id'=>$this->id,
            'comment'=>$this->comment??"",
            'rating'=>$this->rating??0,
            'restaurant_id'=>$this->restaurant_id,
            'created_at'=>$dataa,
            'last_page'=>$this->last_page,
            'from'=>$this->from,
            'f_name'=>$this->customer->f_name??"",
            'l_name'=>$this->customer->l_name??"",
            'image'=>asset($this->customer->image)??"",

        ];

    }
}
