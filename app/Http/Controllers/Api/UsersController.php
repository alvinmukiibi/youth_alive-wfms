<?php

namespace App\Http\Controllers\Api;

use App\Events\UserCreatedEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Resources\ProfileResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\UserFile;
use Illuminate\Support\Facades\Storage;

class UsersController extends BaseController
{
    private $defaultPassword = 'youthalive';
    public $defaultAvatar = 'user.jpg';

    public function __construct()
    {

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
        $user->password = Hash::make($request->password);

        $user->save();

        return $this->sendResponse($user, 'Profile successfully saved!');

    }

    public function getUsers(Request $request){
        $users = User::all();
        $users = ProfileResource::collection($users);

        return $this->sendResponse($users, 'All employees');
    }

    public function activateUser(User $user){
        $user->activity_status = true;
        $user->save();

        return $this->sendResponse('', 'Success');
    }
    public function deactivateUser(User $user){
        $user->activity_status = false;
        $user->save();

        return $this->sendResponse('', 'Success');
    }

    public function validation($request){
        $validator = Validator::make($request->all(), [
            'department_id' => 'required',
            'designation_id' => 'required',
            'contract_id' => 'required',
            'duty_station' => 'required',
            'mobile_contact' => 'required',
            'work_contact' => 'required',
            'home_contact' => 'required',
            'address' => 'required',
            'email' => 'required | email',
        ]);

        return $validator;
    }

    public function saveUserEdit(User $user, Request $request){
        $validator = $this->validation($request);

        if($validator->fails()){
            return $this->sendError('Validation errors', ['error' => $validator->errors()->first()], 429);
        }

        $user->department_id = $request->department_id == ''? $user->department_id: $request->department_id;
        $user->designation_id = $request->designation_id == ''? $user->designation_id: $request->designation_id;
        $user->contract_id = $request->contract_id == ''? $user->contract_id: $request->contract_id;
        $user->duty_station = $request->duty_station;
        $user->email = $request->email;
        $user->work_contact = $request->work_contact;
        $user->mobile_contact = $request->mobile_contact;
        $user->home_contact = $request->home_contact;
        $user->address = $request->address;

        $user->save();

        return $this->sendResponse('', 'Edited successfully');
    }

    public function validationAdd($request){
        $validator = Validator::make($request->all(), [
            'fname' => 'required',
            'lname' => 'required',
            'department_id' => 'required',
            'designation_id' => 'required|numeric',
            'contract_id' => 'required|numeric',
            'duty_station' => 'required',
            'mobile_contact' => 'required',
            'address' => 'required|max:200',
            'email' => 'required | email',
            // 'biodata' => 'nullable | mimes:docx,doc,pdf,xls,xlsx,txt | max:10240'
        ]);

        return $validator;
    }

    public function addUser(Request $request){

        $validator = $this->validationAdd($request);

        if($validator->fails()){
            return $this->sendError('Validation errors', ['error' => $validator->errors()->first()], 429);
        }

        if($request->hasFile('biodata')){
            $validator =  Validator::make($request->all(), [
                'biodata' => 'mimes:docx,doc,pdf,xls,xlsx,txt | max:10240'
            ]);
            if($validator->fails()){
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
            'home_contact' => $request->home_contact == null ? null : $request->home_contact,
            'address' => $request->address,
            'department_id' => $request->department_id,
            'designation_id' => $request->designation_id,
            'contract_id' => $request->contract_id,
            'duty_station' => $request->duty_station,
            'password' => Hash::make($this->defaultPassword),
            'activity_status' => true,
            'email_verified_status' => false,
            'profile_picture' => $this->defaultAvatar,
        ];

        $user = User::create($data);

        UserFile::create(['filename' => $biodata, 'description' => 'users biodata form copy', 'user_id' => $user->id]);

        $event = new UserCreatedEvent($user);
        event($event);

        return $this->sendResponse($user, 'User successfully created');

    }
}
