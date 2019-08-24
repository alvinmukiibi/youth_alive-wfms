<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Resources\ProjectResource;
use App\Project;

class ProjectsController extends BaseController
{
    public function getProjects(Request $request){
        $projects = Project::all();
        $projects = ProjectResource::collection($projects);
        return $this->sendResponse($projects, 'All projects');
    }
}
