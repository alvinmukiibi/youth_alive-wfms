<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\LeavesResource;
use App\Leave;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\LeaveType;
use App\User;
use App\Department;
use App\Designation;
use App\Events\PendingLeaveEvent;
use App\SystemSetting;
use App\Events\LeaveRequestApprovedEvent;

class LeavesController extends BaseController
{
    public $total_annual_leave_days_allowed = 21;

    public function getMyLeaves(Request $request)
    {
        $user = $request->user();
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
        ], [
            'from.after' => 'The start date of the leave must be a date later than today',
            'to.after' => 'The end date of the leave must be a date later than the start date',
        ]);

        return $validator;
    }

    public function getRemaininingDays($user){

        $count = $user->leaves()->where('status', 3)->count();
        if($count > 0){
            $sum_of_leave_days_taken = $user->leaves()->where('status', 3)->sum('duration');
            $remaining_days = $this->total_annual_leave_days_allowed - $sum_of_leave_days_taken;
            return $remaining_days;

        }else{
            return $this->total_annual_leave_days_allowed;
        }

    }

    public function getHolidays(){

        $year = date('Y');
        $holidays=array($year.'-01-01', $year.'-01-26', $year.'-02-16', $year.'-03-08', $year.'-05-01', $year.'-06-03', $year.'-06-09', $year.'-10-09', $year.'-12-25', $year.'-12-26');

        $dynamicDays = SystemSetting::select(['good_friday', 'easter_sunday', 'easter_monday', 'eid_ul_fitr', 'eid_al_adha', 'other_holiday'])->get();
        foreach($dynamicDays as $day){
            $holidays[] = $day['good_friday'] == null ? '' : date('Y-m-d', strtotime($day['good_friday']));
            $holidays[] = $day['easter_sunday'] == null ? '' : date('Y-m-d', strtotime($day['easter_sunday']));
            $holidays[] = $day['easter_monday'] == null ? '' : date('Y-m-d', strtotime($day['easter_monday']));
            $holidays[] = $day['eid_ul_fitr'] == null ? '' : date('Y-m-d', strtotime($day['eid_ul_fitr']));
            $holidays[] = $day['eid_al_adha'] == null ? '' : date('Y-m-d', strtotime($day['eid_al_adha']));
            $holidays[] = $day['other_holiday'] == null ? '' : date('Y-m-d', strtotime($day['other_holiday']));
        }

        return $holidays;

    }

    public function askForLeave(Request $request)
    {
        $user = $request->user();

        // first check if user has any leave request in process
        if ($user->leaves()->where('status', '<', 3)->count() > 0) {
            return $this->sendError('Patience error', ['error' => 'You already have a leave request in process, please first wait until its approved before you make another one']);
        }

        $validator = $this->validation($request);

        if ($validator->fails()) {
            return $this->sendError('Validation errors', ['error' => $validator->errors()->first()], 429);
        }

        $holidays = $this->getHolidays();

        $duration = $this->getWorkingDays($request->from, $request->to, $holidays);

        $days_left = $this->total_annual_leave_days_allowed -  $user->leaves()->where('status', 3)->sum('duration');

        $type = LeaveType::find($request->leave_type_id)->type;

        if ($duration > $days_left) {

            return $this->sendError('Logical error', ['error' => 'You cannot request for more than ' . $days_left . ' days']);

        }

        $leave = [
            'user_id' => $user->id,
            'leave_type_id' => $request->leave_type_id,
            'from' => $request->from,
            'to' => $request->to,
            'comments' => $request->comments ? $request->comments : null,
            'duration' => $duration,
            'status' => 0,
            'total_annual_days_remaining' => $this->getRemaininingDays($user)
        ];

        $leave = Leave::create($leave);

        $leave = new LeavesResource($leave);

        // notify supervisor
        $supervisor = null;
        if ($user->user_type() == 'officer') {
            foreach (Department::find($user->department_id)->users as $use) {
                if ($use->user_type() == 'manager') {
                    $supervisor = $use;
                }
            }
        }
        if ($user->user_type() == 'manager') {
            foreach (Department::find($user->department_id)->users as $use) {
                if ($use->user_type() == 'director') {
                    $supervisor = $use;
                }
            }
        }
        if ($user->user_type() == 'director') {
            $desi = Designation::where('name', 'Executive Director')->value('id');
            $ed = User::where('designation_id', $desi)->first();
            $supervisor = $ed;
        }
        event(new PendingLeaveEvent($supervisor));

        return $this->sendResponse($leave, 'Leave data');
    }

    public function getPendingLeaves(Request $request)
    {

        $user = $request->user();

        if ($user->user_type() == 'manager') {
            $leaves = collect();
            $ids = array();
            $users_in_my_dept = $user->department->users()->where('id', '!=', $user->id)->get();
            foreach ($users_in_my_dept as $off) {
                if ($off->user_type() == 'officer') {
                    $ids[] = $off->id;
                }
            }
            // $lp = Leave::whereIn('user_id', $ids)->whereIn('status', [0, 1, 4])->get();
            $lp = Leave::whereIn('user_id', $ids)->whereIn('status', [0, 1, 2, 3, 4])->get();
            foreach ($lp as $one) {
                $leaves->push($one);
            }

            // if manager is human resource manager, give all requests
            $hr = Department::where('name', 'Human Resource')->value('id');
            if ($user->department_id == $hr) {
                foreach (Leave::whereIn('status', [1, 2, 4])->get() as $two) {
                    $leaves->push($two);
                }
            }
        }
        if ($user->user_type() == 'director') {
            $ids = array();
            $idds = array();
            $leaves = collect();
            $users_in_my_dept = $user->department->users()->where('id', '!=', $user->id)->get();
            foreach ($users_in_my_dept as $off) {
                if ($off->user_type() == 'officer') {
                    $ids[] = $off->id;
                }
            }
            $leav = Leave::whereIn('user_id', $ids)->whereIn('status', [2, 3, 4])->get();
            foreach($leav as $l){
                $leaves->push($l);
            }
            foreach ($users_in_my_dept as $man) {
                if ($man->user_type() == 'manager') {
                    $idds[] = $man->id;
                }
            }
            $leavv = Leave::whereIn('user_id', $idds)->whereIn('status', [0, 1, 4])->get();
            foreach($leavv as $la){
                $leaves->push($la);
            }
            // get leaves for the e.d.

            if($user->designation_id == 1){



            }

        }

        $leaves = LeavesResource::collection($leaves);

        return $this->sendResponse($leaves, 'Leave requests for pending');

    }

    public function cancelLeave(Leave $leave)
    {

        $leave->status = 6;
        $leave->save();

        return $this->sendResponse('success', 'success');

    }
    public function declineLeave(Leave $leave, Request $request)
    {

        $leave->status = 4;
        $leave->updated_by = $request->user()->id;
        $leave->approval_comments = $request->reason;
        $leave->save();

        return $this->sendResponse('success', 'success');

    }
    public function approveLeave(Leave $leave, Request $request)
    {
        $user = $request->user();

        $hr = Department::where('name', 'Human Resource')->value('id');

        if ($user->user_type() == 'manager' && $user->department_id != $hr) {
            $leave->status = 1;
        }
        if ($user->user_type() == 'manager' && $user->department_id == $hr) {
            $leave->status = 2;
        }
        if ($user->user_type() == 'director' && $leave->user->user_type() == 'manager') {
            $leave->status = 1;
        }
        if ($user->user_type() == 'director' && $leave->user->user_type() == 'officer') {
            $leave->status = 3;
            $leave->total_annual_days_remaining = $this->getRemaininingDays($leave->user) - $leave->duration;
            event(new LeaveRequestApprovedEvent($leave));
        }
        // action for the e.d.
        if ($user->user_type() == 'director' && $user->designation_id == 1 && $leave->user->user_type() == 'manager') {
            $leave->status = 3;
            $leave->total_annual_days_remaining = $this->getRemaininingDays($leave->user) - $leave->duration;
            event(new LeaveRequestApprovedEvent($leave));
        }
        if ($user->user_type() == 'director' && $user->designation_id == 1 && $leave->user->user_type() == 'director') {
            $leave->status = 1;
        }

        $leave->updated_by = $user->id;
        $leave->save();

        return $this->sendResponse('success', 'success');

    }

    public function getWorkingDays($startDate, $endDate, $holidays)
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
        // We subtract the holidays
        foreach ($holidays as $holiday) {
            $time_stamp = strtotime($holiday);
            //If the holiday doesn't fall in weekend
            if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N", $time_stamp) != 6 && date("N", $time_stamp) != 7)
                $workingDays--;
        }
        return $workingDays;
    }
    public function setHoliday(Request $request){

        SystemSetting::updateOrCreate(['id' => 1], [$request->field => $request->value]);

        return $this->sendResponse('success', 'success');
    }
}
