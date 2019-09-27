<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\BudgetContactsResource;
use App\Http\Resources\BudgetItemsResource;

class BudgetResource extends JsonResource
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
            'activity' => $this->activity,
            'date' => date('d-M-Y', strtotime($this->date)),
            'destination' => $this->destination,
            'purpose' => $this->purpose,
            'comments' => $this->comments,
            'total' => \number_format($this->total),
            'items' => BudgetItemsResource::collection($this->travelscopebudgetitem),
            'contacts' => BudgetContactsResource::collection($this->travelscopebudgetcontact)
        ];
    }
}
