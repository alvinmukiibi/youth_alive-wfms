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
       $response = [
            'id' => $this->id,
            'user' => $this->user->fname . ' ' . $this->user->lname,
            'year' => $this->year,
            'month' => $this->month,
            'projects' => TimesheetProjectResource::collection($this->projects)
        ];

        for ($i = 1; $i <= 31; $i++) {
            $response['scheduled']['sch__'.$i] = $this->{'sch__'.$i};
        }

        $response['statistics'] = $this->statistics()->firstOrCreate(['timesheet_id' => $this->id], ['scheduled_hours' => 0, 'worked_hours' => 0, 'overtime_hours' => 0, 'total_hours_worked' => 0, 'percentage_time' => 0]);

        return $response;
    }
}
