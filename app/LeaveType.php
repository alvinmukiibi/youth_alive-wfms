<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Leave;

class LeaveType extends Model
{
    protected $guarded = ['id'];

    public function leave(){
        return $this->hasMany(Leave::class, 'leave_type_id');
    }
}
