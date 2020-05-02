<?php

namespace App\Http\Resources;

use App\Department;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentsResource extends JsonResource
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
            'acronym' => $this->acronym,
            'role' => $this->role,
            'directorate' => $this->directorate_id ? $this->directorate->name : null,
        ];
    }
}
