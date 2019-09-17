<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Department;
class Directorate extends Model
{
    protected $guarded = ['id'];

    public function departments(){
        return $this->hasMany(Department::class, 'directorate_id');
    }
}
