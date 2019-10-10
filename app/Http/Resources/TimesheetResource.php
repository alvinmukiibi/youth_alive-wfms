<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TimesheetResource extends JsonResource
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
            'user' => $this->user->fname . ' ' . $this->user->lname,
            'year' => $this->year,
            'month' => $this->month,
            'projects' => TimesheetProjectResource::collection($this->projects)
        ];
    }
}
