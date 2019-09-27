<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleHotelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $res= [];
        if($this->vehicle){
            $res['vehicle'] = true;
            $res['departure_date'] = $this->departure_date;
            $res['return_date'] = $this->return_date;
            $res['departure_venue'] = $this->departure_venue;
            $res['reason'] = $this->reason;
            $res['name_of_passengers'] = $this->name_of_passengers;
        }

        if($this->hotel){
            $res['hotel'] = true;
            $res['purpose'] = $this->purpose;
            $res['bookings'] = BookingsResource::collection($this->hotelbooking);
        }

        return $res;
    }
}
