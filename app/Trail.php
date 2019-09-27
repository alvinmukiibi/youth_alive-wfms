<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProgramRequest;
class Trail extends Model
{
    protected $guarded = ['id'];

    public function request(){
        return $this->belongsTo(ProgramRequest::class, 'request_id');
    }
}
