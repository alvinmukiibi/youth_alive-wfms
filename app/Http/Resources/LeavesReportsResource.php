<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TrackersResource;
class LeavesReportsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $currentYear = date('Y');
        $currentMonth = date('m');
        $max_annual_days = 21;
        return [
            'staff' => $this->fname . ' ' . $this->lname,
            'availability' => $this->availability_status ? 'ON DUTY' : 'ON LEAVE',
            'days_taken' => new TrackersResource($this->trackers()->first()),
            'days_remaining' => $this->leaves_remaining(),

            // 'cumulative_leave_days_this_year' => $this->leaves()->where('status', 3)->sum('duration'),
            // 'pending_leaves' => $this->leaves()->where('status', '<', 3)->count(),
            // 'leaves_this_month' => $this->leaves()->whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth)->where('status', 3)->sum('duration'),
            // 'total_annual_days_allowed' => $this->leaves()->value('total_annual_days_allowed') == null ? $max_annual_days : $this->leaves()->value('total_annual_days_allowed'),
        ];
    }
}
