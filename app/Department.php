<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\ProgramRequest;
use App\Directorate;
class Department extends Model
{
    protected $guarded = ['id'];

    public function users(){
        return $this->hasMany(User::class, 'department_id');
    }
    public function requests(){
        return $this->hasMany(ProgramRequest::class, 'department_id');
    }

    public function directorate(){
        return $this->belongsTo(Directorate::class, 'directorate_id');
    }
}
