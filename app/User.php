<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Designation;
use App\Role;
use App\Request;
use App\Leave;
use App\Setting;
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
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    public function requests(){
        return $this->hasMany(Request::class, 'user_id');
    }
    public function leaves(){
        return $this->hasMany(Leave::class, 'user_id');
    }
    public function settings(){
        return $this->hasOne(Setting::class, 'user_id');
    }

    public function arrayOfRoles(){
        $roles = [];
        foreach($this->roles as $role){
            $roles[] = $role['name'];
        }
        return $roles;
    }
    public function arrayOfProjects(){
        $projects = [];
        foreach($this->projects as $project){
            $projects[] = $project['name'];
        }
        return $projects;
    }
    public function user_type(){
        $roles = $this->arrayOfRoles();
        if(in_array('officer', $roles) && count($roles) == 1){
            return 'officer';
        }
        if(in_array('manager', $roles)){
            return 'manager';
        }
        if(in_array('director', $roles)){
            return 'director';
        }
    }
}
