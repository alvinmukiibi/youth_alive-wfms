<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Timesheet;
use App\Project;

class TimesheetProject extends Model
{
    protected $guarded = ['id'];

    public function timesheet(){
        return $this->belongsTo(Timesheet::class, 'timesheet_id');
    }
    public function project(){
        return $this->hasOne(Project::class, 'project_id');
    }

    public function sub_total(){

        $sum = 0;
        for($i = 1; $i < 32; $i++){
            $value = $this['_'.$i.'_'];
            if($value != null){
                $sum += $value;
            }
        }
        return $sum;
    }
}
