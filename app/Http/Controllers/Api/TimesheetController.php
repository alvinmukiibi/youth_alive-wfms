<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Resources\TimesheetResource;
use App\Timesheet;
use Illuminate\Http\Request;

class TimesheetController extends BaseController
{
    public function index(Request $request){

        $user = auth()->user();
        $month = explode('-', $request->date)[1];
        $year = explode('-', $request->date)[0];

        $timesheet = $user->timesheets()->where(['year' => $year, 'month' => $month])->first();

        $timesheet = new TimesheetResource($timesheet);

        return $this->sendResponse($timesheet, 'Timesheet data');
    }
}
