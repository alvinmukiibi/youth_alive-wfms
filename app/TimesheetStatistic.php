<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Timesheet;

class TimesheetStatistic extends Model
{
    protected $guarded = ['id'];

    public function timesheet(){
        return $this->belongsTo(Timesheet::class, 'timesheet_id');
    }
}
