<?php

namespace App\Http\Controllers\Api;

use App\Contract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Project;
use App\User;
use Illuminate\Support\Facades\DB;
class AdminController extends BaseController
{
    public function addProject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'supervisor' => ['nullable', 'exists:users,id'],
            'description' => ['nullable', 'max:1000'],
        ]);

        if($validator->fails()){
            return $this->sendError('Validation errors', ['error' => $validator->errors()->first()], 429);
        }

        $project = [
            'name' => $request->name,
            'description' => $request->description ? $request->description : null,
            'supervisor' => $request->supervisor ? $request->supervisor : null,
        ];

        $project = Project::create($project);

        if($request->supervisor){
            User::find($request->supervisor)->projects()->attach($project->id);
        }

        return $this->sendResponse($project, 'New project saved!');


    }

    public function editProject(Project $project, Request $request){

        $project->name = $request->name;
        $project->description = $request->description;
        $project->supervisor = $request->supervisor;
        $project->save();

        $count = DB::table('project_user')->where(['user_id' => $request->supervisor, 'project_id' => $request->id])->count();
        if($count > 0){
            return $this->sendError('', 'Project already attached to user');
        }else{
            $user = User::find($request->supervisor);
            $user->projects()->attach($request->id);
        }
        return response()->json('Success', 200);

    }
}
