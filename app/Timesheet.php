<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\TimesheetProject;

class Timesheet extends Model
{
    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function projects(){
        return $this->hasMany(TimesheetProject::class, 'timesheet_id');
    }
}
