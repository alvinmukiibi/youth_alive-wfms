<?php

namespace App\Http\Resources;
use App\User;
use App\Project;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgramRequestResource extends JsonResource
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
            'activity_type' => $this->activity_type,
            'documents' => $this->documents,
            'doc_completion_status' => $this->doc_completion_status,
            'id' => $this->id,
            'identity' => $this->identity,
            'project' => Project::find($this->project_id)->name,
            'user' => User::find($this->user_id)->fname . ' ' . User::find($this->user_id)->fname
        ];
    }
}
