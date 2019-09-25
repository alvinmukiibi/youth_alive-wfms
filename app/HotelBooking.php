<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\VehicleHotel;
class HotelBooking extends Model
{
    protected $guarded = ['id'];

    public function vehiclehotel(){
        return $this->belongsTo(VehicleHotel::class, 'vehicle_hotel_id');
    }
}
