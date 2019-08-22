<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Project extends Model
{
    protected $guarded = ['id'];

    public function users(){
        return $this->belongsToMany(User::class);
    }
}
