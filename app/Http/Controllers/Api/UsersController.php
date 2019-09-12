<?php

namespace App\Http\Controllers\Api;

use App\Events\UserCreatedEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Resources\ProfileResource;
use App\RoleUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\UserFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UsersController extends BaseController
{
    private $defaultPassword = 'youthalive';
    public $defaultAvatar = 'user.jpg';

    public function __construct()
    { }

    public function saveProfile(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'user_name' => 'required',
            'password' => 'required | min:8 | alpha_num'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation errors', ['error' => $validator->errors()->first()], 429);
        }

        $user->user_name = $request->user_name;
        $user->password = Hash::make($request->password);

        $user->save();

        return $this->sendResponse($user, 'Profile successfully saved!');
    }

    public function getUsers(Request $request)
    {
        $users = User::all();
        $users = ProfileResource::collection($users);

        return $this->sendResponse($users, 'All employees');
    }

    public function activateUser(User $user)
    {
        $user->activity_status = true;
        $user->save();

        return $this->sendResponse('', 'Success');
    }
    public function deactivateUser(User $user)
    {
        $user->activity_status = false;
        $user->save();

        return $this->sendResponse('', 'Success');
    }

    public function validation($request)
    {
        $validator = Validator::make($request->all(), [
            // 'department_id' => 'required',
            // 'designation_id' => 'required',
            // 'contract_id' => 'required',
            'duty_station' => 'required',
            'mobile_contact' => 'required',
            'work_contact' => 'required',
            'address' => 'required',
            'email' => 'required | email',
        ], [
            'duty_station.required' => 'The duty station field is required',
            'mobile_contact.required' => 'The mobile contact field is required',
            'work_contact.required' => 'The work contact field is required',
            // 'department_id.required' => 'Please choose a department for the user',
            // 'designation_id.required' => 'Please choose a designation for the user',
            // 'contract_id.required' => 'Please choose a contract type for the user',
            'email.required' => 'The email address field is required',
            'address.required' => 'The address field is required',

        ]);

        return $validator;
    }

    public function saveUserEdit(User $user, Request $request)
    {
        $validator = $this->validation($request);

        if ($validator->fails()) {
            return $this->sendError('Validation errors', ['error' => $validator->errors()->first()], 429);
        }

        $user->department_id = $request->department_id == '' ? $user->department_id : $request->department_id;
        $user->designation_id = $request->designation_id == '' ? $user->designation_id : $request->designation_id;
        $user->contract_id = $request->contract_id == '' ? $user->contract_id : $request->contract_id;
        $user->duty_station = $request->duty_station;
        $user->email = $request->email;
        $user->work_contact = $request->work_contact;
        $user->mobile_contact = $request->mobile_contact;
        $user->address = $request->address;

        $user->save();

        $user = new ProfileResource($user);

        return $this->sendResponse($user, 'Edited successfully');
    }

    public function validationAdd($request)
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required',
            'lname' => 'required',
            'department_id' => 'required',
            'designation_id' => 'required|numeric',
            'contract_id' => 'required|numeric',
            'duty_station' => 'required',
            'mobile_contact' => 'required',
            'address' => 'required|max:200',
            'email' => 'required|email|unique:users',
        ], [
            'fname.required' => 'The first name field is required',
            'lname.required' => 'The last name field is required',
            'department_id.required' => 'Please choose a department for the user',
            'designation_id.required' => 'Please choose a designation for the user',
            'contract_id.required' => 'Please choose a contract type for the user',
            'email.required' => 'The email address field is required',

        ]);

        return $validator;
    }

    public function addUser(Request $request)
    {

        $validator = $this->validationAdd($request);

        if ($validator->fails()) {
            return $this->sendError('Validation errors', ['error' => $validator->errors()->first()], 429);
        }

        if ($request->hasFile('biodata')) {
            $validator =  Validator::make($request->all(), [
                'biodata' => 'mimes:docx,doc,pdf,xls,xlsx,txt | max:10240'
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation errors', $validator->errors(), 422);
            }

            $biodata = Storage::disk('public')->putFile('files', $request->file('biodata'));
        }

        $data = [
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'mobile_contact' => $request->mobile_contact,
            'work_contact' => $request->work_contact == null ? null : $request->work_contact,
            'staff_id' => $request->staff_id == null ? null : $request->staff_id,
            'address' => $request->address,
            'department_id' => $request->department_id,
            'designation_id' => $request->designation_id,
            'contract_id' => $request->contract_id,
            'duty_station' => $request->duty_station,
            'password' => Hash::make($this->defaultPassword),
            'activity_status' => true,
            'availability_status' => true,
            'email_verified_status' => false,
            'profile_picture' => null,
        ];

        $user = User::create($data);

        $user->roles()->attach(1); // make every user an officer on registration
        if ($request->hasFile('biodata')) {

            UserFile::create(['filename' => $biodata, 'description' => 'users biodata form copy', 'user_id' => $user->id]);
        }
        $event = new UserCreatedEvent($user);
        event($event);

        return $this->sendResponse($user, 'User successfully created');
    }

    public function attachRole(Request $request)
    {

        $count = DB::table('role_user')->where(['user_id' => $request->user_id, 'role_id' => $request->role_id])->count();
        if ($count > 0) {
            return $this->sendError('', 'Role already attached to user');
        } else {
            $user = User::find($request->user_id);
            $user->roles()->attach($request->role_id);
            return $this->sendResponse('', 'Role successfully attached');
        }
    }
    public function attachProject(Request $request)
    {

        $count = DB::table('project_user')->where(['user_id' => $request->user_id, 'project_id' => $request->project_id])->count();
        if ($count > 0) {
            return $this->sendError('', 'Project already attached to user');
        } else {
            $user = User::find($request->user_id);
            $user->projects()->attach($request->project_id);
            return $this->sendResponse('', 'Project successfully attached');
        }
    }
    public function detachProject(Request $request)
    {

        $count = DB::table('project_user')->where(['user_id' => $request->user_id, 'project_id' => $request->project_id])->count();
        if ($count > 0) {
            $user = User::find($request->user_id);
            $user->projects()->detach($request->project_id);
            return $this->sendResponse('', 'Project successfully detached');
        } else {
            return $this->sendError('', 'User doesnot have that project');
        }
    }
    public function detachRole(Request $request)
    {

        $count = DB::table('role_user')->where(['user_id' => $request->user_id, 'role_id' => $request->role_id])->count();
        if ($count > 0) {
            $user = User::find($request->user_id);
            $user->roles()->detach($request->role_id);
            return $this->sendResponse('', 'Role successfully detached');
        } else {
            return $this->sendError('', 'User doesnot have that role');
        }
    }

    public function saveDp(User $user, Request $request)
    {

        $validator = Validator::make($request->all(), [
            'profile_picture' => ['mimes:jpeg,jpg,png,webp,gif']
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation errors', ['error' => $validator->errors()->first()], 429);
        }

        $dp = Storage::disk('public')->putFile('users', $request->file('profile_picture'));
        $user->profile_picture = $dp;
        $user->save();

        return $this->sendResponse('Saved', 'Dp saved!!');
    }
}
