<?php

namespace App\Http\Resources;

use App\Contract;
use App\Department;
use App\Designation;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'fname' => \ucwords($this->fname),
            'lname' => \ucwords($this->lname),
            'user_name' => $this->user_name,
            'email' => $this->email,
            'work_contact' => $this->work_contact,
            'mobile_contact' => $this->mobile_contact,
            'staff_id' => $this->staff_id,
            'address' => $this->address,
            'profile_picture' => $this->profile_picture,
            'duty_station' => $this->duty_station,
            'department' => Department::find($this->department_id)->name,
            'department_acronym' => Department::find($this->department_id)->acronym,
            'designation' => Designation::find($this->designation_id)->name,
            'roles' => $this->arrayOfRoles(),
            'projects' => $this->arrayOfProjects(),
            'contract' => Contract::find($this->contract_id)->name,
            'activity_status' => $this->activity_status,
            'created_at' => date('Y-M-d', strtotime($this->created_at))
        ];
    }
}
