<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\LeavesResource;
use App\Leave;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\LeaveType;
use App\User;

class LeavesController extends BaseController
{
    public function getMyLeaves(User $user)
    {

        $leaves = $user->leaves;
        $leaves = LeavesResource::collection($leaves);

        return $this->sendResponse($leaves, 'User`s leave requests');
    }

    public function validation($request)
    {

        $validator = Validator::make($request->all(), [
            'leave_type_id' => 'required|exists:leave_types,id',
            'from' => 'required|date|after:today',
            'to' => 'required|date|after:from',
            'comments' => 'nullable|max:200'
        ]);

        return $validator;
    }

    public function askForLeave(Request $request)
    {
        $user = $request->user();

        $validator = $this->validation($request);

        if ($validator->fails()) {
            return $this->sendError('Validation errors', ['error' => $validator->errors()->first()], 429);
        }

        $duration = $this->getWorkingDays($request->from, $request->to);
        $max_days = LeaveType::find($request->leave_type_id)->days;
        $type = LeaveType::find($request->leave_type_id)->type;

        if($duration > $max_days){

            return $this->sendError('Logical error', ['error' => 'You cannot request for more than ' . $max_days . ' days of the ' . $type . ' leave']);

        }

        $leave = [
            'user_id' => 1, //$user->id,
            'leave_type_id' => $request->leave_type_id,
            'from' => $request->from,
            'to' => $request->to,
            'comments' => $request->comments ? $request->comments : null,
            'duration' => $duration,
            'status' => 0,
        ];

        $leave = Leave::create($leave);
        $leave = new LeavesResource($leave);

        // $holidays=array('2019-01-01', '2019-01-26', '2019-02-16');

        return $this->sendResponse($leave, 'Leave data');

    }

    public function getWorkingDays($startDate, $endDate)
    {
        // do strtotime calculations just once
        $endDate = strtotime($endDate);
        $startDate = strtotime($startDate);
        //The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
        //We add one to inlude both dates in the interval.
        $days = ($endDate - $startDate) / 86400 + 1;
        $no_full_weeks = floor($days / 7);
        $no_remaining_days = fmod($days, 7);
        //It will return 1 if it's Monday,.. ,7 for Sunday
        $the_first_day_of_week = date("N", $startDate);
        $the_last_day_of_week = date("N", $endDate);
        //---->The two can be equal in leap years when february has 29 days, the equal sign is added here
        //In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
        if ($the_first_day_of_week <= $the_last_day_of_week) {
            if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
            if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
        } else {
            // (edit by Tokes to fix an edge case where the start day was a Sunday
            // and the end day was NOT a Saturday)
            // the day of the week for start is later than the day of the week for end
            if ($the_first_day_of_week == 7) {
                // if the start date is a Sunday, then we definitely subtract 1 day
                $no_remaining_days--;
                if ($the_last_day_of_week == 6) {
                    // if the end date is a Saturday, then we subtract another day
                    $no_remaining_days--;
                }
            } else {
                // the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
                // so we skip an entire weekend and subtract 2 days
                $no_remaining_days -= 2;
            }
        }
        //The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
        //---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
        $workingDays = $no_full_weeks * 5;
        if ($no_remaining_days > 0) {
            $workingDays += $no_remaining_days;
        }
        //We subtract the holidays
        // foreach ($holidays as $holiday) {
        //     $time_stamp = strtotime($holiday);
        //     //If the holiday doesn't fall in weekend
        //     if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N", $time_stamp) != 6 && date("N", $time_stamp) != 7)
        //         $workingDays--;
        // }
        return $workingDays;
    }

    public function getAllLeaves(Request $request){

        $leaves = Leave::latest()->get();
        $leaves = LeavesResource::collection($leaves);

        return $this->sendResponse($leaves, 'All leave requests');

    }
}
