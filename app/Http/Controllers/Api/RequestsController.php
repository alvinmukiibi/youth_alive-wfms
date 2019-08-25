<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Request as Req;
use App\Http\Resources\RequestsResource;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;

class RequestsController extends BaseController
{
    public function __construct()
    {

    }

    public function validation($request){
        $validator = Validator::make($request->all(),
        [
            'delivery_date' => ['required', 'date', 'after_or_equal:today'],
            'vendor_id' => ['required', 'numeric', 'exists:vendors,id'],
            'department_id' => ['required','numeric', 'exists:departments,id'],
            'project_id' => ['required','numeric', 'exists:projects,id'],
            'activity_type' => ['required'],
            'asset_id' => ['nullable', 'exists:assets,id'],
            'quantity' => ['nullable', 'numeric'],
            'unit_cost' => ['nullable', 'numeric'],
            'comments' => ['nullable', 'max:200'],
        ]);

        return $validator;
    }

    public function addRequest(Request $request){
        $requestor = $request->user();

        $validator = $this->validation($request);

        if($validator->fails()){
            return $this->sendError('Validation errors', ['error' => $validator->errors()->first()], 429);
        }

        if(!in_array('officer', $requestor->arrayOfRoles())){
            return $this->sendError('Permission errors', ['error' => 'Permission denied, please make sure you have the rights of an officer role']);
        }


    }
}
