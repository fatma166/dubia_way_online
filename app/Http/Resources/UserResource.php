<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
        return
            [    'id' => $this->id,
                //  'role_id' => RoleResource::collection($this->role_id),
                'name' => $this->f_name??'',
                'last_name' => $this->l_name??'',
                'email' => $this->email??'',
                'phone'=>$this->phone??'',
                'avatar'=>asset($this->image)??'',
                'token'=>$this->token??'',
                'last_login'=>$this->last_login??'',
                'address_id'=>$this->address->id??0,
            'address_text'=>  ($this->address->address??'') ." - " .($this->address->floor??'')." - " .($this->address->road??'')." - " .($this->address->house??''),
            'address_address'=>$this->address->address??'',
            'address_floor'=>$this->address->floor??'',
             'address_road'=>$this->address->road??'',
              'address_house'=>$this->address->house??'',




            ];
    }
}
