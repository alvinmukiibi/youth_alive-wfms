<?php

namespace App\Http\Resources;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'accountant' => $this->accountant ? User::find($this->accountant)->fname . ' ' . User::find($this->accountant)->lname : null,
            'manager' => $this->manager ? User::find($this->manager)->fname . ' ' . User::find($this->manager)->lname : null
        ];
    }
}
