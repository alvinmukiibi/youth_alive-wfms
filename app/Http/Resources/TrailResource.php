<?php

namespace App\Http\Resources;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class TrailResource extends JsonResource
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
            'request_id' => $this->request_id,
            'requestor' =>  User::find($this->requestor_id)->fname . ' ' . User::find($this->requestor_id)->lname,
            'requestor_comments' => $this->requestor_comments,
            'requested_date' => date('d-M-Y', \strtotime($this->requested_date)),

            'accountant_approval' => $this->accountant_approval,
            'accountant' => $this->accountant_approval ? User::find($this->accountant_id)->fname . ' ' . User::find($this->accountant_id)->lname: null,
            'acc_comments' => $this->accountant_comments,
            'acc_appro_date' => date('d-M-Y', \strtotime($this->accountant_approval_date)),

            'level_one_approval' => $this->level_one_approval,
            'level_one_approver' => $this->level_one_approval ? User::find($this->level_one_approver_id)->fname . ' ' . User::find($this->level_one_approver_id)->lname : null,
            'level_one_comments' => $this->level_one_approver_comments,
            'level_one_date' => date('d-M-Y', \strtotime($this->level_one_approval_date)),

            'finance_approval' => $this->finance_approval,
            'finance_approver' => $this->finance_approval ? User::find($this->finance_approver_id)->fname . ' ' . User::find($this->finance_approver_id)->lname : null,
            'finance_appro_comments' => $this->finance_approver_comments,
            'finance_approval_date' => $this->finance_approval_date ? date('d-M-Y', \strtotime($this->finance_approval_date)): null,

            'level_two_approval' => $this->level_two_approval,
            'level_two_approver' => $this->level_two_approval ? User::find($this->level_two_approver_id)->fname . ' ' . User::find($this->level_two_approver_id)->lname : null,
            'level_two_comments' => $this->level_two_approver_comments,
            'level_two_date' => $this->level_two_approval_date ? date('d-M-Y', \strtotime($this->level_two_approval_date)) : null,

            'level_three_approval' => $this->level_three_approval,
            'level_three_approver' => $this->level_three_approval ? User::find($this->level_three_approver_id)->fname . ' ' . User::find($this->level_three_approver_id)->lname : null,
            'level_three_comments' => $this->level_three_approver_comments,
            'level_three_date' => $this->level_three_approval_date ? date('d-M-Y', \strtotime($this->level_three_approval_date)) : null,
        ];
    }
}
