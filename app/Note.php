<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProgramRequest;
use App\User;

class Note extends Model
{
    protected $guarded = ['id'];

    public function programrequest(){
        return $this->belongsTo(ProgramRequest::class, 'program_request_id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
