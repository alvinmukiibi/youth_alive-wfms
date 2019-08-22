<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Designation extends Model
{
    protected $guarded = ['id'];

    public function users(){
        return $this->hasMany(User::class, 'designation_id');
    }
}
