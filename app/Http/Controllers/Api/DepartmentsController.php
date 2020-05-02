<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Department;
use App\Directorate;
use App\http\Resources\Departmentsresource;

class DepartmentsController extends BaseController
{
    public function getDepartments(Request $request){
        $depts = Department::orderBy('name', 'asc')->get();
        $depts = DepartmentsResource::collection($depts);
        return $this->sendResponse($depts, 'All departments');
    }

    public function getDirectorates(Request $request){
        $dirs = Directorate::orderBy('name', 'asc')->get();
        return $this->sendResponse($dirs, 'All directorates');
    }

    public function store(Request $request){

        $dept = [
            'name' => $request->name,
            'acronym' => $request->acronym,
            'role' => $request->role ? $request->role : null,
            'directorate_id' => $request->directorate_id
        ];

        $dept = Department::create($dept);
        $dept = new DepartmentsResource($dept);
        return $this->sendResponse($dept, 'Department created!');

    }
    public function update(Department $department, Request $request){

        $department->name = $request->name;
        $department->acronym = $request->acronym;
        $department->directorate_id = $request->directorate_id ? $request->directorate_id : $department->directorate_id;
        $department->role = $request->role ? $request->role : null;

        $department->save();
        $department = new DepartmentsResource($department);
        return $this->sendResponse($department, 'Department saved!');

    }

}
