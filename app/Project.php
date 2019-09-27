<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\ProgramRequest;

class Project extends Model
{
    protected $guarded = ['id'];

    public function users(){
        return $this->belongsToMany(User::class);
    }
    public function requests(){
        return $this->hasMany(ProgramRequest::class, 'project_id');
    }
}
