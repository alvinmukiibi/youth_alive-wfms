<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Designation;
use App\Role;
use App\ProgramRequest;
use App\Leave;
use App\Setting;
use App\Directorate;

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

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function directorate()
    {
        return $this->belongsTo(Directorate::class, 'directorate_id');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    public function requests()
    {
        return $this->hasMany(ProgramRequest::class, 'user_id');
    }
    public function leaves()
    {
        return $this->hasMany(Leave::class, 'user_id');
    }
    public function settings()
    {
        return $this->hasOne(Setting::class, 'user_id');
    }

    public function arrayOfRoles()
    {
        $roles = [];
        foreach ($this->roles as $role) {
            $roles[] = $role['name'];
        }
        return $roles;
    }
    public function arrayOfProjects()
    {
        $projects = [];
        foreach ($this->projects as $project) {
            $projects[] = $project['name'];
        }
        return $projects;
    }
    public function user_type()
    {
        $roles = $this->arrayOfRoles();
        if (in_array('officer', $roles) && count($roles) == 1) {
            return 'officer';
        }
        if (in_array('manager', $roles)) {
            return 'manager';
        }
        if (in_array('director', $roles)) {
            return 'director';
        }
    }

    public function isHQStaff(){
        if(Str::containes($this->duty_station, 'Kampala')){
            return true;
        }
        return false;
    }

    public function supervisor()
    {
        /**
         * your supervisor is the user above you in the organogram
         * if youre an officer, then your supervisor is the manager of your department
         * if youre an officer in the PM dept, your supervisor is the manager of that project
         * if youre a manager, your supervisor is the director of the directorate where your dept falls
         * if youre a director, your supervisor is the executive director
         *
         *
         * */
        $post = $this->user_type();
        $users = User::all();
        $admin = User::first();

        switch ($post) {
            case 'officer':
                $response = null;
                foreach ($users as $user) {
                    if ($user->user_type() == 'manager' && $user->department == $this->department) {
                        $response = $user;
                    }
                }
                return $response ? $response : $admin;
                break;
            case 'manager':
                $response1 = null;
                foreach($users as $user){
                    if($user->user_type() == 'director' && $user->directorate == $this->department->directorate){
                        $response1 = $user;
                    }
                }
                return $response1 ? $response1 : $admin;
                break;
            case 'director':

                $designation = Designation::where('name', 'Executive Director')->value('id');
                $executive_director = User::where('designation_id', $designation)->first();
                return $executive_director ? $executive_director : $admin;
                break;

            default:
                return $admin;
                break;
        }


    }
}
