<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;

class RepliesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'message' => $this->message,
            'attachment' => $this->attachment,
            'recipient' => User::find($this->recipient_id),
            'sender' => User::find($this->sender_id),
            'date_sent' => date('d-M-Y H:i', strtotime($this->created_at))
        ];
    }
}
