<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class UsersController extends BaseController
{
    public function __construct()
    {

    }

    public function validationSuccess($validator){
        if($validator->fails()){
            return $this->sendError('Validation errors', $validator->errors()->first(), 429);
        }
    }

    public function saveProfile(Request $request){
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'user_name' => 'required',
            'password' => 'required | min:8 | alpha_num'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation errors', ['error' => $validator->errors()->first()], 429);
        }

        $user->user_name = $request->user_name;
        $user->password = $request->password;

        $user->save();

        return $this->sendResponse($user, 'Profile successfully saved!');

    }
}
