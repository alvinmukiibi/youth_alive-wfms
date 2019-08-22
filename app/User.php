<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Designation;
use App\Role;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'activity_status' => 'boolean',
        'email_verified_status' => 'boolean',
    ];

    public function designation(){
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    public function department(){
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function projects(){
        return $this->belongsToMany(Project::class);
    }

    public function roles(){
        return $this->belongsToMany(Role::class);
    }
}
