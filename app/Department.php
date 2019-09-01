<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Request as Req;
class Department extends Model
{
    protected $guarded = ['id'];

    public function users(){
        return $this->hasMany(User::class, 'department_id');
    }
    public function requests(){
        return $this->hasMany(Req::class, 'department_id');
    }
}
