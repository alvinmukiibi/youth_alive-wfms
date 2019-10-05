<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\LeaveType;

class TrackersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $response = [];
        $leave_types = [];

        foreach(LeaveType::all() as $obj){
            $leave_types[] = $obj['type'];
        }
        foreach($leave_types as $leave_type){
            $response[$leave_type] = $this[\strtolower($leave_type)];
        }

        $response['year'] = $this->year;

        return $response;


        // $response['hospitalization'] = $this->hospitalization,
        // $response['maternity'] = $this->maternity,
        // $response['paternity'] = $this->paternity,
        // $response['study'] = $this->study,
        // $response['annual'] = $this->annual,
        // $response['compassionate'] = $this->compassionate,
        // $response['year' = $this->year,
    }
}
