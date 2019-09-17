<?php

namespace App\Http\Resources;

use App\LeaveType;
use Illuminate\Http\Resources\Json\JsonResource;
use App\User;

class LeavesResource extends JsonResource
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
            'user' => User::find($this->user_id)->fname . ' ' . User::find($this->user_id)->lname,
            'leave_type' => LeaveType::find($this->leave_type_id)->type,
            'leave_type_days' => LeaveType::find($this->leave_type_id)->days,
            'total_days_left' => $this->total_annual_days_remaining,
            'leave_first_day' => \date('d-M-Y', \strtotime($this->from)),
            'leave_last_day' => \date('d-M-Y', \strtotime($this->to)),
            'duration_of_leave' => $this->duration,
            'comments' => $this->comments,
            'reason' => $this->approval_comments,
            'status' => $this->status,
            'user_type' => User::find($this->user_id)->user_type(),
            'request_date' => \date('d-M-Y', \strtotime($this->created_at))
        ];
    }
}
