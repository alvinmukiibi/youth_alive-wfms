<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\TimesheetResource;
use App\Timesheet;
use App\User;
use Illuminate\Http\Request;
use App\TimesheetStatistic;
use Illuminate\Support\Facades\Validator;

class TimesheetController extends BaseController
{
    public function __construct()
    {
        $user = auth()->user();
    }
    public function index(Request $request)
    {

        $user = auth()->user();
        $month = explode('-', $request->date)[1];
        $year = explode('-', $request->date)[0];

        // if the month is a past month, dont populate newly attached projects

        $date_sent = date('m-Y', strtotime($request->date));
        $current_date = date('m-Y');

        if ($current_date == $date_sent) {
            $this->populateAttachedProjects($month, $year);
        }

        $timesheet = $user->timesheets()->where(['year' => $year, 'month' => $month])->first();

        if ($timesheet) {
            $timesheet = new TimesheetResource($timesheet);
        }

        return $this->sendResponse($timesheet, 'Timesheet data');
    }

    public function getStaffTimesheet(Request $request){

        $user = User::find($request->staff);
        $month = explode('-', $request->period)[1];
        $year = explode('-', $request->period)[0];

        $timesheet = $user->timesheets()->where(['year' => $year, 'month' => $month])->first();

        if ($timesheet) {
            $timesheet = new TimesheetResource($timesheet);
        }

        return $this->sendResponse(['timesheet' => $timesheet, 'staff' => new ProfileResource($user)], 'Timesheet data');

    }

    public function populateAttachedProjects($month, $year)
    {

        $user = auth()->user();

        $projects = $user->projects;

        $timesheet = $user->timesheets()->firstOrCreate(['month' => $month, 'year' => $year]);

        foreach ($projects as $project) {
            $timesheet->projects()->firstOrCreate(['project_id' => $project->id]);
        }

        return;
    }

    public function validate_max_8($request)
    {

        $validator = Validator::make($request->all(), [
            'value' => 'required|numeric|max:8',
        ], [
            'value.required' => 'Please select a value',
            'value.max' => 'Value cannot be greater than 8 hours',
        ]);

        return $validator;
    }

    public function saveScheduled(Request $request)
    {

        $validator = $this->validate_max_8($request);

        if ($validator->fails()) {
            return $this->sendError('error', ['error' => $validator->errors()->first()]);
        }

        $timesheet = Timesheet::find($request->timesheet);

        $timesheet->update([$request->field => $request->value]);

        // deserves a cron job
        $sum = 0;
        for ($i = 1; $i <= 31; $i++) {
            if ($timesheet['sch__' . $i]) {
                $sum += $timesheet['sch__' . $i];
            }
        }

        $timesheet->statistics()->update(['scheduled_hours' => $sum]);

        return $this->sendResponse('success', 'success');
    }

    public function saveWorked(Request $request)
    {

        $timesheet = Timesheet::find($request->timesheet);

        $timesheet->statistics()->update(['worked_hours' => $request->worked_hours]);

        $total_hours_worked = $timesheet->statistics->overtime_hours + $timesheet->statistics->worked_hours;
        $timesheet->statistics()->update(['total_hours_worked' => $total_hours_worked]);

        $percentage =  $total_hours_worked / $timesheet->statistics->scheduled_hours * 100;
        $timesheet->statistics()->update(['percentage_time' => $percentage]);

        return $this->sendResponse('success', 'success');
    }

    public function saveOvertime(Request $request)
    {

        $timesheet = Timesheet::find($request->timesheet);

        $timesheet->statistics()->update(['overtime_hours' => $request->value]);

        $total_hours_worked = $timesheet->statistics->overtime_hours + $timesheet->statistics->worked_hours;
        $timesheet->statistics()->update(['total_hours_worked' => $total_hours_worked]);
        $percentage =  $total_hours_worked / $timesheet->statistics->scheduled_hours * 100;
        $timesheet->statistics()->update(['percentage_time' => $percentage]);

        return $this->sendResponse('success', 'success');
    }
    public function saveTimesheet(Request $request)
    {

        $user = auth()->user();

        $validator = $this->validate_max_8($request);

        if ($validator->fails()) {
            return $this->sendError('error', ['error' => $validator->errors()->first()]);
        }

        $month = $request->month;
        $year = $request->year;
        $project_id = $request->project_id;
        $value = $request->value;
        $field = '_' . $request->field . '_';

        $timesheet = $user->timesheets()->where(['year' => $year, 'month' => $month])->first();
        $timesheet->projects()->where(['project_id' => $project_id])->update([$field => $value]);

        return $this->sendResponse('success', 'success');
    }

    public function getMySubs(Request $request){

        $user = auth()->user();
        $subs = [];
        $users = User::all();

        if($user->user_type() == 'manager' && $user->department->name != 'Human Resource'){
            // subs are officers under the department i head
            foreach($users as $us){
                if($us->user_type() == 'officer' && $us->department == $user->department){
                    $subs[] = $us;
                }
            }
        }

        if($user->user_type() == 'manager' && $user->department->name == 'Human Resource'){
            // subs are officers under the department i head
            $subs = $users;
        }

        if($user->user_type() == 'director'){
            // subs are managers who head depts under the directorate i head
            $dir = $user->directorate;

            foreach($users as $use){
                if($use->directorate == $dir && $use->user_type() == 'manager'){
                    $subs[] = $use;
                }
            }
        }

        return $this->sendResponse($subs, 'My suboordinates');

    }
}
