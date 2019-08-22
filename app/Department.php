<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Department extends Model
{
    protected $guarded = ['id'];

    public function users(){
        return $this->hasMany(User::class, 'designation_id');
    }
}
