<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Resources\LeavesReportsResource;

class ReportsController extends BaseController
{
    public function leaveReports(Request $request){

        $users = User::all();
        $users = LeavesReportsResource::collection($users);
        return $this->sendResponse($users, 'Users leaves summary');

    }
}
