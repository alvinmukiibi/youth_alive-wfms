<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TravelScopeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'travellers' => $this->travellers,
            'date_of_activity' => $this->date_of_activity,
            'destination' => $this->destination,
            'departure_point' => $this->departure_point,
            'departure_date' => $this->departure_date,
            'return_date' => $this->return_date,
            'objectives' => $this->objectives,
            'activities' => $this->activities,
            'key_people_to_be_met' => $this->key_people_to_be_met,
            'expected_deliverables' => $this->expected_deliverables,
        ];
    }
}
