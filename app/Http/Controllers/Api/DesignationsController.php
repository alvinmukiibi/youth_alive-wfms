<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Designation;

class DesignationsController extends BaseController
{
    public function getDesignations(Request $request){
        $designations = Designation::all();
        return $this->sendResponse($designations, 'All designations');
    }
}
