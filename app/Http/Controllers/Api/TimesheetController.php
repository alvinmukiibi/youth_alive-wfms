<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Resources\TimesheetResource;
use App\Timesheet;
use Illuminate\Http\Request;
use App\TimesheetStatistic;

class TimesheetController extends BaseController
{
    public function index(Request $request)
    {

        $user = auth()->user();
        $month = explode('-', $request->date)[1];
        $year = explode('-', $request->date)[0];

        // if the month is a past month, dont populate newly attached projects

        $date_sent = date('m-Y', strtotime($request->date));
        $current_date = date('m-Y');

        if($current_date == $date_sent){
            $this->populateAttachedProjects($month, $year);
        }

        $timesheet = $user->timesheets()->where(['year' => $year, 'month' => $month])->first();

        if($timesheet){
            $timesheet = new TimesheetResource($timesheet);
        }

        return $this->sendResponse($timesheet, 'Timesheet data');
    }

    public function populateAttachedProjects($month, $year){

        $user = auth()->user();

        $projects = $user->projects;

        $timesheet = $user->timesheets()->firstOrCreate(['month' => $month, 'year' => $year]);

        foreach($projects as $project){
            $timesheet->projects()->firstOrCreate(['project_id' => $project->id]);
        }

        return;

    }

    public function saveScheduled(Request $request){

        $timesheet = Timesheet::find($request->timesheet);

        $timesheet->update([$request->field => $request->value]);

        // deserves a cron job
        $sum = 0;
        for ($i = 1; $i <= 31; $i++) {
           if($timesheet['sch__'.$i]){
              $sum += $timesheet['sch__'.$i];
           }
        }

        $timesheet->statistics()->update(['scheduled_hours' => $sum]);

        return $this->sendResponse('success', 'success');

    }

    public function saveWorked(Request $request){

        $timesheet = Timesheet::find($request->timesheet);

        $timesheet->statistics()->update(['worked_hours' => $request->worked_hours]);

        $total_hours_worked = $timesheet->statistics->overtime_hours + $timesheet->statistics->worked_hours;
        $timesheet->statistics()->update(['total_hours_worked' => $total_hours_worked]);

        return $this->sendResponse('success', 'success');

    }

    public function saveOvertime(Request $request){

        $timesheet = Timesheet::find($request->timesheet);

        $timesheet->statistics()->update(['overtime_hours' => $request->value]);

        $total_hours_worked = $timesheet->statistics->overtime_hours + $timesheet->statistics->worked_hours;
        $timesheet->statistics()->update(['total_hours_worked' => $total_hours_worked]);

        return $this->sendResponse('success', 'success');

    }
    public function saveTimesheet(Request $request){

        $user = auth()->user();

        $month = $request->month;
        $year = $request->year;
        $project_id = $request->project_id;
        $value = $request->value;
        $field = '_'.$request->field.'_';

        $timesheet = $user->timesheets()->where(['year' => $year, 'month' => $month])->first();
        $timesheet->projects()->where(['project_id' => $project_id])->update([$field => $value]);

        return $this->sendResponse('success', 'success');

    }
}
