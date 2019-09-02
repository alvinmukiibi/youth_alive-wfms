<?php

namespace App\Http\Resources;

use App\Http\Resources\ReqAssetResource;
use App\Vendor;
use App\Department;
use App\Project;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestsResource extends JsonResource
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
            'identity' => $this->identity,
            'delivery_date' => $this->delivery_date,
            'activity_type' => $this->activity_type,
            'vendor' => Vendor::find($this->vendor_id),
            'department' => Department::find($this->department_id),
            'project' => Project::find($this->project_id),
            'date_of_request' => date('d-M', strtotime($this->created_at)),
            'trail' => $this->trail,
            'assets' => ReqAssetResource::collection($this->assets),
            'requested_by' => \ucwords(User::find($this->user_id)->fname . ' ' . User::find($this->user_id)->lname),
            'requestor_type' => $this->getRequestorType(),
            'attachments' => $this->attachments,
        ];
    }
}
