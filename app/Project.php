<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Request;

class Project extends Model
{
    protected $guarded = ['id'];

    public function users(){
        return $this->belongsToMany(User::class);
    }
    public function requests(){
        return $this->hasMany(Request::class, 'project_id');
    }
}
