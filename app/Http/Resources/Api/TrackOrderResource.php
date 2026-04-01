<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TrackOrderResource extends JsonResource
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
            'id'=>$this->id,
            'user_id'=>$this->user_id,
            'order_status'=>$this->order_status,
            'delivery_address_id'=>$this->delivery_address_id??0,
            'accepted'=>($this->accepted!= "")?Carbon::parse($this->accepted)->format('d-m-Y H:i:s'):"",
            'confirmed'=>($this->confirmed!= "")?Carbon::parse($this->confirmed)->format('d-m-Y H:i:s'):"",
            'delivered'=>($this->delivered!= "")?Carbon::parse($this->delivered)->format('d-m-Y H:i:s'):"",
            'picked_up'=>($this->picked_up!= "")?Carbon::parse($this->picked_up)->format('d-m-Y H:i:s'):"",
           // 'delivery_address'=>$this->delivery_address,
            'processing_time'=>($this->processing_time!= "")?Carbon::parse($this->processing_time)->format('d-m-Y H:i:s'):"",
            'details_count'=>$this->details_count??0,
            'payment_method'=>$this->payment_method??"",
            'order_note'=>$this->order_note??"",
            'restaurant_id'=>$this->restaurant_id??0,
            'restaurant_name'=>$this->restaurant->name??"",
            'restaurant_phone'=>$this->restaurant->phone??"",
            'delivery_time'=>$this->restaurant->delivery_time??0,
            'delivery_time_unit'=>$this->restaurant->delivery_time_unit=="hours"?__($this->restaurant->delivery_time_unit):__("minutes"),

            'restaurant_logo_url'=>$this->restaurant->logo_url??"",
            'delivery_charge'=>$this->delivery_charge,
            'order_amount'=>$this->order_amount,
            'address'=> $this->whenLoaded('customer_address', function () {
                return   ( ($this->customer_address->address?$this->customer_address->address:'') ." - " .($this->customer_address->floor?$this->customer_address->floor:'')." - " .($this->customer_address->road?$this->customer_address->road:'')." - " .($this->customer_address->house?$this->customer_address->house:''));
                 //return AddressResource::collection($this->customer_address->address ." -" .$this->customer_address->floor ." -" .$this->customer_address->road ." -" .$this->customer_address->house);
            })??"",


         //

        ];
    }
}
