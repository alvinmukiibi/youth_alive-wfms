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
        $response['project_id'] = $this->project_id;
        $response['name'] = Project::find($this->project_id)->name;
        $response['1'] = $this['_1_'];
        $response['2'] = $this['_2_'];
        $response['3'] = $this['_3_'];
        $response['4'] = $this['_4_'];
        $response['5'] = $this['_5_'];
        $response['6'] = $this['_6_'];
        $response['7'] = $this['_7_'];
        $response['8'] = $this['_8_'];
        $response['9'] = $this['_9_'];
        $response['10'] = $this['_10_'];
        $response['11'] = $this['_11_'];
        $response['12'] = $this['_12_'];
        $response['13'] = $this['_13_'];
        $response['14'] = $this['_14_'];
        $response['15'] = $this['_15_'];
        $response['16'] = $this['_16_'];
        $response['17'] = $this['_17_'];
        $response['18'] = $this['_18_'];
        $response['19'] = $this['_19_'];
        $response['20'] = $this['_20_'];
        $response['21'] = $this['_21_'];
        $response['22'] = $this['_22_'];
        $response['23'] = $this['_23_'];
        $response['24'] = $this['_24_'];
        $response['25'] = $this['_25_'];
        $response['26'] = $this['_26_'];
        $response['27'] = $this['_27_'];
        $response['28'] = $this['_28_'];
        $response['29'] = $this['_29_'];
        $response['30'] = $this['_30_'];
        $response['31'] = $this['_31_'];
        $response['sub_total'] = $this->sub_total();

        $response['last_updated_at'] = $this->updated_at->diffForHumans();

        return $response;
    }
}
