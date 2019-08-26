<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Request as Req;
class Trail extends Model
{
    protected $guarded = ['id'];

    public function request(){
        return $this->belongsTo(Req::class);
    }
}
