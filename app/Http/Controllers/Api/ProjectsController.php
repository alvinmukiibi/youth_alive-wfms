<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Project;

class ProjectsController extends BaseController
{
    public function getProjects(Request $request){
        $projects = Project::all();

        return $this->sendResponse($projects, 'All projects');
    }
}
