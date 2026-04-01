<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            "id"=> $this->id,
            "conversation_id"=> $this->conversation_id,
            "sender_id"=>$this->sender_id,
            "message"=>$this->message,
            "file"=> $this->file,
            "is_seen"=> $this->is_seen,
            "user_id"=>$this->whenLoaded('sender', function () {
                    return   $this->sender->user_id;

                })?? 0,
            "created_at"=>$this->created_at
            ];

    }
}
