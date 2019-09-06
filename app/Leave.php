<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\LeaveType;
class Leave extends Model
{
    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function leavetype(){
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }
}
