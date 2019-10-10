<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Project;

class TimesheetProjectResource extends JsonResource
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
        $response['name'] = Project::find($this->project_id)->name;
        $response['1'] = $this['1'];
        $response['2'] = $this['2'];
        $response['3'] = $this['3'];
        $response['4'] = $this['4'];
        $response['5'] = $this['5'];
        $response['6'] = $this['6'];
        $response['7'] = $this['7'];
        $response['8'] = $this['8'];
        $response['9'] = $this['9'];
        $response['10'] = $this['10'];
        $response['11'] = $this['11'];
        $response['12'] = $this['12'];
        $response['13'] = $this['13'];
        $response['14'] = $this['14'];
        $response['15'] = $this['15'];
        $response['16'] = $this['16'];
        $response['17'] = $this['17'];
        $response['18'] = $this['18'];
        $response['19'] = $this['19'];
        $response['20'] = $this['20'];
        $response['21'] = $this['21'];
        $response['22'] = $this['22'];
        $response['23'] = $this['23'];
        $response['24'] = $this['24'];
        $response['25'] = $this['25'];
        $response['26'] = $this['26'];
        $response['27'] = $this['27'];
        $response['28'] = $this['28'];
        $response['29'] = $this['29'];
        $response['30'] = $this['30'];
        $response['31'] = $this['31'];

        $response['last_updated_at'] = $this->updated_at->diffForHumans();

        return $response;

    }
}
