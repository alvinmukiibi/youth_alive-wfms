<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TravelScope;
use App\VehicleHotel;
use App\TravelscopeBudget;
use App\Trail;
class ProgramRequest extends Model
{

    protected $guarded = ['id'];

    public function travelscope(){
        return $this->hasOne(TravelScope::class, 'program_request_id');
    }
    public function vehiclehotel(){
        return $this->hasOne(VehicleHotel::class, 'program_request_id');
    }
    public function travelscopebudget(){
        return $this->hasOne(TravelscopeBudget::class, 'program_request_id');
    }
    public function trail(){
        return $this->hasOne(Trail::class, 'request_id');
    }
    public function requestor(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function project(){
        return $this->belongsTo(Project::class, 'project_id');
    }
    public function department(){
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function attachments(){
        return $this->hasMany(Attachment::class, 'request_id');
    }
    public function getRequestorType(){
        $roles = $this->requestor->arrayOfRoles();
        if(in_array('officer', $roles) && !in_array('manager', $roles) && !in_array('director', $roles)){
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
