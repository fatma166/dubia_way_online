<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return //parent::toArray($request);
        [
            'id'=>$this->id,
            'name'=>$this->name??"",
            'parent_id'=>$this->parent_id??0,
            'position'=>$this->position,
            'priority'=>$this->priority,
            'compilation_id'=>$this->compilation_id??1
        ];
    }
}
