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
        $year = date('Y');

        return [
            'id' => $this->id,
            'user' => $this->user->fname . ' ' . $this->user->lname,
            'leave_type' => LeaveType::find($this->leave_type_id)->type,
            'leave_type_days' => LeaveType::find($this->leave_type_id)->days,
            'leave_first_day' => \date('d-M-Y', \strtotime($this->from)),
            'leave_last_day' => \date('d-M-Y', \strtotime($this->to)),
            'duration_of_leave' => $this->duration,
            'comments' => $this->comments,
            'reason' => $this->approval_comments,
            'status' => $this->status,
            'user_type' => $this->user->user_type(),
            'request_date' => \date('d-M-Y', \strtotime($this->created_at)),
            'days_taken' => $this->user->trackers()->whereYear('created_at', '2019')->first(),
        ];
    }
}
