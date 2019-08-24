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

    public function store(Request $request){

        $desi = [
            'name' => $request->name,
        ];

        $desi = Designation::create($desi);

        return $this->sendResponse($desi, 'Designation created!');

    }
    public function update(Designation $designation, Request $request){

        $designation->name = $request->name;
        $designation->save();

        return $this->sendResponse($designation, 'Designation saved!');

    }

    public function delete(Designation $designation){
        $designation->delete();
        return $this->sendResponse($designation, 'Designation deleted!');

    }

}
