<?php

namespace App\Http\Resources;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class NotesResource extends JsonResource
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
            'note' => $this->note,
            'user' => User::find($this->user_id)->fname . ' ' . User::find($this->user_id)->lname,
            'date_made' => date('d-M-Y H:i', strtotime($this->created_at)),
        ];
    }
}
