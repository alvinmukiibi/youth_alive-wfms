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

    public function store(Request $request){

        $dept = [
            'name' => $request->name,
            'acronym' => $request->acronym,
            'role' => $request->role ? $request->role : null,
        ];

        $dept = Department::create($dept);

        return $this->sendResponse($dept, 'Department created!');

    }
    public function update(Department $department, Request $request){

        $department->name = $request->name;
        $department->acronym = $request->acronym;
        $department->role = $request->role ? $request->role : null;

        $department->save();

        return $this->sendResponse($department, 'Department saved!');

    }

}
