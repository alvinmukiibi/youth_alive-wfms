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
}
