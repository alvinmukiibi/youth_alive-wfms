<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BudgetItemsResource extends JsonResource
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
            'no' => $this->no,
            'item' => \ucwords($this->item),
            'units' => $this->units,
            'frequency' => $this->frequency,
            'unit_cost' => $this->unit_cost,
            'sub_total' => $this->sub_total,
        ];
    }
}
