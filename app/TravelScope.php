<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProgramRequest;

class TravelScope extends Model
{
    protected $guarded = ['id'];

    public function programrequest(){
        return $this->belongsTo(ProgramRequest::class, 'program_request_id');
    }
}
