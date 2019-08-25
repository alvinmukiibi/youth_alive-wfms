<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Request as Req;

class Attachment extends Model
{
    protected $guarded = ['id'];

    public function request(){
        return $this->belongsTo(Req::class, 'request_id');
    }
}
