<?php

namespace App\Http\Controllers\Api;

use App\Attachment;
use App\Department;
use App\Events\RequestCreatedEvent;
use Illuminate\Http\Request;
use App\Request as Req;
use App\Http\Resources\RequestsResource;
use App\Http\Controllers\BaseController;
use App\Project;
use App\RequestedAsset;
use App\Trail;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RequestsController extends BaseController
{
    public function __construct()
    { }

    public function validation($request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'delivery_date' => ['required', 'date', 'after_or_equal:today'],
                'vendor_id' => ['required', 'numeric', 'exists:vendors,id'],
                'department_id' => ['required', 'numeric', 'exists:departments,id'],
                'project_id' => ['required', 'numeric', 'exists:projects,id'],
                'activity_type' => ['required'],
                'requestor_comments' => ['nullable', 'max:200'],
            ]
        );

        return $validator;
    }
    public function validationEdit($request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                // 'delivery_date' => ['nullable', 'date', 'after_or_equal:today'],
                // 'vendor_id' => ['nullable', 'numeric', 'exists:vendors,id'],
                // 'activity_type' => ['nullable'],
                'requestor_comments' => ['nullable', 'max:200'],
            ]
        );

        return $validator;
    }

    public function updateRequest(Request $request)
    {
        $requestor = $request->user();

        $req = Req::find($request->segment(4));

        $validator = $this->validationEdit($request);

        if ($validator->fails()) {
            return $this->sendError('Validation errors', ['error' => $validator->errors()->first()], 429);
        }
        $data = [
            'activity_type' => $request->activity_type != 'null' ?  $request->activity_type : $req->activity_type,
            'vendor_id' => $request->vendor_id != 'null' ?  $request->vendor_id : $req->vendor_id,
            'delivery_date' => $request->delivery_date != 'null' ?  $request->delivery_date : $req->delivery_date,

        ];
        $req->update($data);

        $trail = $req->trail;
        $trail->requestor_comments = $request->filled('requestor_comments') ?  $request->requestor_comments : $req->requestor_comments;
        $trail->save();


        if ($request->filled('asset_id')) {
            $asset = $req->assets()->first();
            $asset->quantity = $request->quantity ? $request->quantity : $asset->quantity;
            $asset->unit_cost = $request->unit_cost ? $request->unit_cost : $asset->unit_cost;
            $asset->comments = $request->comments ? $request->comments : $asset->comments;
            $asset->total_cost  = $asset->unit_cost * $asset->quantity;
            $asset->save();
        }

        if ($request->hasFile('attachments')) {
            foreach ($request->attachments as $file) {
                $ref = Storage::disk('public')->put('attachments', $file);
                Attachment::create(['request_id' => $req->id, 'reference' => $ref]);
            }
        }


        return $this->sendResponse($req, 'Saved successfully');
    }

    public function addRequest(Request $request)
    {
        $requestor = $request->user();

        $validator = $this->validation($request);

        if ($validator->fails()) {
            return $this->sendError('Validation errors', ['error' => $validator->errors()->first()], 429);
        }

        if (!in_array('officer', $requestor->arrayOfRoles())) {
            return $this->sendError('Permission errors', ['error' => 'Permission denied, please make sure you have the rights of an officer role']);
        }

        $req = [
            'delivery_date' => $request->delivery_date,
            'activity_type' => $request->activity_type,
            'vendor_id' => $request->vendor_id,
            'department_id' => $request->department_id,
            'project_id' => $request->project_id,
            'user_id' => $requestor->id
        ];

        $req['identity'] = $this->generateRequestIdentity($request);

        $req = Req::create($req);

        $trail = [
            'request_id' => $req->id,
            'requestor_id' => $requestor->id,
            'requestor_comments' => $request->requestor_comments ? $request->requestor_comments : null,
            'requested_date' => date('Y-m-d H:i')
        ];

        $trail = Trail::create($trail);

        if ($request->filled('asset_id')) {

            $validator = Validator::make($request->all(), [
                'asset_id' => ['required', 'exists:assets,id'],
                'quantity' => ['required', 'numeric'],
                'unit_cost' => ['required', 'numeric'],
                'comments' => ['nullable', 'max:200'],
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation errors', ['error' => $validator->errors()->first()], 429);
            }

            $asset = [
                'asset_id' => $request->asset_id,
                'quantity' => $request->quantity,
                'request_id' => $req->id,
                'unit_cost' => $request->unit_cost,
                'comments' => $request->comments ? $request->comments : null,
            ];

            $asset['total_cost'] = $asset['quantity'] * $asset['unit_cost'];

            RequestedAsset::create($asset);
        }


        if ($request->hasFile('attachments')) {
            foreach ($request->attachments as $file) {
                $ref = Storage::disk('public')->put('attachments', $file);
                Attachment::create(['request_id' => $req->id, 'reference' => $ref]);
            }
        }

        // notifications
        // request upwards, approve downwards
        // project accountant approved all requests on their projects

        $accountant = User::find(Project::find($req->project_id)->accountant);
        event(new RequestCreatedEvent($accountant));

        // if (count($requestor->arrayOfRoles()) == 1 && in_array('officer', $requestor->arrayOfRoles())) {
        //     // you are solely an officer
        //     // notify your project accountant

        // }

        // if (in_array('manager', $requestor->arrayOfRoles())) {
        //     // you are a manager
        //     // notify project manager
        // }

        // if (in_array('director', $requestor->arrayOfRoles())) {
        //     // you are a director
        //     // not now
        // }

        return $this->sendResponse($req, 'Request created!');
    }

    public function getMyRequests(Request $request)
    {

        $user = $request->user();

        $requests = $user->requests;
        $requests = RequestsResource::collection($requests);

        return $this->sendResponse($requests, 'All my requests');
    }

    public function generateRequestIdentity($request)
    {

        $activity_type = $request->activity_type;
        $activity_type = \strtoupper($activity_type);
        $activity = \substr($activity_type, 0, 2);

        $project = Project::find($request->project_id)->value('name');
        $project = \strtoupper($project);
        $project = \substr($project, 0, 3);

        $identity = $activity . '/' . $project . '/' . $this->random_strings(4);

        return $identity;
    }

    public function random_strings($length_of_string)
    {
        $str_result = '0123456789YOUTHALIVEUGANDA';
        return substr(str_shuffle($str_result),  0, $length_of_string);
    }

    public function getProjectRequests(Request $request)
    {

        $user = $request->user();

        $project_id = Project::where('accountant', $user->id)->value('id');
        $requests = Project::find($project_id)->requests;
        $requests = RequestsResource::collection($requests);

        return $this->sendResponse($requests, 'Project requests for the accountant');
    }
    public function getLevel1Requests(Request $request)
    {
        $user = $request->user();

        $department = Department::find($user->department_id);
        $requests = $department->requests;
        $requests = RequestsResource::collection($requests);

        return $this->sendResponse($requests, 'Requests for level 1 approval');
    }
    public function getFMRequests(Request $request)
    {
        $requests = collect();
        foreach(Req::all() as $req){
            if($req->trail->level_one_approval == 1){
                $requests->push($req);
            }
        }
        $requests = RequestsResource::collection($requests);
        return $this->sendResponse($requests, 'Requests for finance approval');
    }


    public function getEDRequests(Request $request){

        $reqs = collect();
        $requests = Req::all();
        foreach($requests as $req){
            if($req->trail->level_two_approval == 1){
                $reqs->push($req);
            }
        }

        $reqs = RequestsResource::collection($reqs);
        return $this->sendResponse($reqs, 'Requests for ED approval');

    }

    public function getDirectorRequests(Request $request)
    {
        $reqs = collect();

        $user = $request->user();

        // requests in directors line of department
        $requests = Department::find($user->department_id)->requests;

        foreach($requests as $req){
            if($req->trail->finance_approval == 1){
                $reqs->push($req);
            }
        }

        $reqs = RequestsResource::collection($reqs);
        return $this->sendResponse($reqs, 'Requests for directors approval');
    }

    public function approveRequest(Request $request)
    {
        $req = Req::find($request->request_id);
        $field = $request->field;
        if($field == 'accountant_approval'){
            $traceability_id = 'accountant_id';
            $traceability_date = 'accountant_approval_date';
            $this->notifySuperviser($req);
        }
        if($field == 'level_one_approval'){
            $traceability_id = 'level_one_approver_id';
            $traceability_date = 'level_one_approval_date';
            // for an officer
            $this->notifyFinanceManager($req);
        }
        if($field == 'finance_approval'){
            $traceability_id = 'finance_approver_id';
            $traceability_date = 'finance_approval_date';
            // for an officer
            $this->notifyDirector1($req);
        }
        if($field == 'level_two_approval'){
            $traceability_id = 'level_two_approver_id';
            $traceability_date = 'level_two_approval_date';
            // for an officer
            $this->notifyLastDirector($req);
        }
        if($field == 'level_three_approval'){
            $traceability_id = 'level_three_approver_id';
            $traceability_date = 'level_three_approval_date';
            // for an officer
            // $this->notifyLastDirector($req);
        }

        $trail = $req->trail;
        $trail[$field] = true;
        $trail[$traceability_id] = $request->user()->id;
        $trail[$traceability_date] = date('d-M-Y H:i');
        $trail->save();

        return $this->sendResponse('success', 'success');
    }

    public function notifyFinanceManager($request){

        // send these to finance manager for approval

        foreach(Department::where('name', 'Finance and Operations')->first()->users as $user){

            if(in_array('manager', $user->arrayOfRoles())){
                $finance_manager = $user;
            }

        }

        event(new RequestCreatedEvent($finance_manager));

    }
    public function notifyDirector1($request){

        // send these to finance manager for approval
        foreach(Department::find($request->department_id)->users as $user){
            if(in_array('director', $user->arrayOfRoles())){
                $director = $user;
            }
        }

        event(new RequestCreatedEvent($director));

    }
    public function notifyLastDirector(){

        // send these to finance manager for approval

        $desi = Designation::where('name', 'Executive Director')->value('id');

        event(new RequestCreatedEvent(User::where('designation_id', $desi)->first()));

    }

    public function notifySuperviser($request){

        $requestor = User::find($request->user_id);
        $dept = $requestor->department_id;
        $requestor_roles = $requestor->arrayOfRoles();

        if (count($requestor_roles) == 1 && in_array('officer', $requestor_roles)) {
            // you are solely an officer
            // notify your dept manager who is your supervisor
            foreach(Department::find($dept)->users as $user){
                if(in_array('manager', $user->arrayOfRoles())){
                    $supervisor = $user;
                }
            }
            event(new RequestCreatedEvent($supervisor));
        }

        if (in_array('manager', $requestor_roles)) {
            // you are a manager
            // notify your line director
            foreach(Department::find($dept)->users as $user){
                if(in_array('director', $user->arrayOfRoles())){
                    $director = $user;
                }
            }
            event(new RequestCreatedEvent($director));
        }

        if (in_array('director', $requestor_roles)) {
            // you are a director
            // not now
        }



    }
}
