<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Department;
class DepartmentsController extends BaseController
{
    public function getDepartments(Request $request){
        $depts = Department::all();
        return $this->sendResponse($depts, 'All departments');
    }
}
