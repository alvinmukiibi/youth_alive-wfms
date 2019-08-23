<?php

namespace App\Http\Controllers\Api;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
class RolesController extends BaseController
{
    public function getRoles(Request $request){
        $roles = Role::all();

        return $this->sendResponse($roles, 'Roles');
    }
}
