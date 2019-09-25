<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TravelScope;
use App\VehicleHotel;

class ProgramRequest extends Model
{
    public function travelscope(){
        return $this->hasOne(TravelScope::class, 'program_request_id');
    }
    public function vehiclehotel(){
        return $this->hasOne(VehicleHotel::class, 'program_request_id');
    }
}
