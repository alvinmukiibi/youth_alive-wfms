<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Role extends Model
{
    protected $guarded = ['id'];

    public function users(){
        return $this->belongsToMany(User::class);
    }
}
