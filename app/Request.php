<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Project;
use App\Vendor;
use App\Department;
use App\RequestedAsset;
use App\Trail;
class Request extends Model
{
    protected $guarded = ['id'];

    public function requestor(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function project(){
        return $this->belongsTo(Project::class, 'project_id');
    }
    public function vendor(){
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
    public function department(){
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function assets(){
        return $this->hasMany(RequestedAsset::class, 'request_id');
    }
    public function attachments(){
        return $this->hasMany(Attachment::class, 'request_id');
    }
    public function trail(){
        return $this->hasOne(Trail::class);
    }
}
