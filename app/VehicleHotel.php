<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProgramRequest;
use App\HotelBooking;
class VehicleHotel extends Model
{
    protected $guarded = ['id'];

    public function programrequest(){
        return $this->belongsTo(ProgramRequest::class, 'program_request_id');
    }
    public function hotelbooking(){
        return $this->hasMany(HotelBooking::class, 'vehicle_hotel_id');
    }
}
