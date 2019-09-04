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
use App\Designation;
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

        // disable the following trail tokens for those users
        if($req->getRequestorType == 'manager'){
            $trail['finance_approval'] = null;
        }
        if($req->getRequestorType == 'director'){
            $trail['finance_approval'] = null;
            $trail['level_three_approval'] = null;
        }

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
        event(new RequestCreatedEvent($accountant, $requestor));

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
        // get requests that the accountant has approved but manager/supervisor has not yet approved and the request was instituted by an officer

        $user = $request->user();

        $department = Department::find($user->department_id);
        $requests = $department->requests;
        $reqs = collect();
        foreach ($requests as $req) {
            if ($req->getRequestorType() == 'officer' && $req->trail->accountant_approval == 1) {
                $reqs->push($req);
            }
        }
        $reque = RequestsResource::collection($reqs);

        return $this->sendResponse($reque, 'Requests for level 1 approval');
    }
    public function getFMRequests(Request $request)
    {
        // requests from an officer and a manager and has level one approval for each
        $requests = collect();
        foreach (Req::all() as $req) {
            if ($req->trail->level_one_approval == 1 && $req->getRequestorType() == 'officer') {
                $requests->push($req);
            }
            if ($req->trail->level_one_approval == 1 && $req->getRequestorType() == 'manager') {
                $requests->push($req);
            }
        }
        $requests = RequestsResource::collection($requests);
        return $this->sendResponse($requests, 'Requests for finance approval');
    }


    public function getEDRequests(Request $request)
    {

        $reqs = collect();
        $requests = Req::all();
        foreach ($requests as $req) {
            if ($req->trail->level_two_approval == 1) {
                $reqs->push($req);
            }
            // get requests made by directors, for level 2 which is the last approval
            if ($req->getRequestorType() == 'director' && $req->trail->level_one_approval == 1 && $req->trail->level_two_approval == 0) {
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

        foreach ($requests as $req) {
            // those requiring level 2 approvals i.e. officer requests
            if ($req->trail->finance_approval == 1 && $req->getRequestorType() == 'officer') {
                $reqs->push($req);
            }
            // those requiring level 1 approvals i.e. manager requests
            if ($req->trail->accountant_approval == 1 && $req->getRequestorType() == 'manager') {
                $reqs->push($req);
            }

        }

        // get requests from the ED for approval
        // $all = Req::all();
        // foreach($all)

        // if the director is a finance director, then get director requests for level 1 approval
        $dept_id = Department::where('name', 'Finance and Operations')->value('id');
        if (auth()->user()->department_id == $dept_id) {
            $directorrequests = Req::all();
            foreach($directorrequests as $re){
                if ($re->trail->accountant_approval == 1 && $re->getRequestorType() == 'director') {
                    $reqs->push($re);
                }
            }
        }

        $reqs = RequestsResource::collection($reqs);
        return $this->sendResponse($reqs, 'Requests for directors approval');
    }

    public function approveRequest(Request $request)
    {
        $req = Req::find($request->request_id);
        $field = $request->field;
        if ($field == 'accountant_approval') {
            $traceability_id = 'accountant_id';
            $traceability_date = 'accountant_approval_date';
            $this->notifyLevelOne($req);
        }
        if ($field == 'level_one_approval') {
            $traceability_id = 'level_one_approver_id';
            $traceability_date = 'level_one_approval_date';
            // for an officer
            $this->notifyFinanceManager($req);
        }

        if ($field == 'level_two_approval') {
            if ($req->getRequestorType() == 'manager') {
                $field = 'level_one_approval';
                $traceability_id = 'level_one_approver_id';
                $traceability_date = 'level_one_approval_date';
                $this->notifyFinanceManager($req); // for level two approval

            }
            if ($req->getRequestorType() == 'director') {
                $field = 'level_one_approval';
                $traceability_id = 'level_one_approver_id';
                $traceability_date = 'level_one_approval_date';

                // if requestor is the ED himself
                if($req->requestor->designation_id == 1){
                    // notify all other directors
                    $directors = [];
                    $all_users = User::all();
                    foreach($all_users as $user){
                        // if the directors dont include the finance director and the executive director
                        if(in_array('director', $user->arrayOfRoles()) && $user->designation_id != 1 && $user->id != auth()->user()->id){
                            $directors[] = $user;
                        }
                    }
                    // notify all these directors, whoever gets there first approves it
                    foreach($directors as $dir){
                        event(new RequestCreatedEvent($dir, $req->requestor));
                    }

                }else{
                    $this->notifyLastDirector($req); // for last level (2) approval
                }

            }
            else {
                $traceability_id = 'level_two_approver_id';
                $traceability_date = 'level_two_approval_date';
                // for an officer
                $this->notifyLastDirector($req);
            }
        }
        if ($field == 'finance_approval') {
            if ($req->getRequestorType() == 'manager') {
                $field = 'level_two_approval';
                $traceability_id = 'level_two_approver_id';
                $traceability_date = 'level_two_approval_date';
                $this->notifyLastDirector($req); // for last approval

            } else {
                $traceability_id = 'finance_approver_id';
                $traceability_date = 'finance_approval_date';
                // for an officer
                $this->notifyDirector1($req);
            }
        }
        if ($field == 'level_three_approval') {
            if ($req->getRequestorType() == 'director') {
                $field = 'level_two_approval';
                $traceability_id = 'level_two_approver_id';
                $traceability_date = 'level_two_approval_date';
                // the end of a director request
            }else{
                $traceability_id = 'level_three_approver_id';
                $traceability_date = 'level_three_approval_date';
                // for an officer
                // $this->notifyLastDirector($req);
            }
        }

        $trail = $req->trail;
        $trail[$field] = true;
        $trail[$traceability_id] = $request->user()->id;
        $trail[$traceability_date] = date('d-M-Y H:i');
        $trail->save();

        // event(new RequestUpdateEvent($req->requestor));

        return $this->sendResponse('success', 'success');
    }
    public function declineRequest(Request $request)
    {
        $comments = $request->comments;
        $req = Req::find($request->request_id);
        $field = $request->field;
        if ($field == 'accountant_approval') {
            $traceability_id = 'accountant_id';
            $traceability_date = 'accountant_approval_date';
            $traceability_comments = 'accountant_comments';
            $this->notifyLevelOne($req);
        }
        if ($field == 'level_one_approval') {
            $traceability_id = 'level_one_approver_id';
            $traceability_date = 'level_one_approval_date';
            $traceability_comments = 'level_one_approver_comments';
            // for an officer
            $this->notifyFinanceManager($req);
        }

        if ($field == 'level_two_approval') {
            if ($req->getRequestorType() == 'manager') {
                $field = 'level_one_approval';
                $traceability_id = 'level_one_approver_id';
                $traceability_date = 'level_one_approval_date';
                $traceability_comments = 'level_one_approver_comments';
                $this->notifyFinanceManager($req); // for level two approval

            }
            if ($req->getRequestorType() == 'director') {
                $field = 'level_one_approval';
                $traceability_id = 'level_one_approver_id';
                $traceability_date = 'level_one_approval_date';
                $traceability_comments = 'level_one_approver_comments';

                // if requestor is the ED himself
                if($req->requestor->designation_id == 1){
                    // notify all other directors
                    $directors = [];
                    $all_users = User::all();
                    foreach($all_users as $user){
                        // if the directors dont include the finance director and the executive director
                        if(in_array('director', $user->arrayOfRoles()) && $user->designation_id != 1 && $user->id != auth()->user()->id){
                            $directors[] = $user;
                        }
                    }
                    // notify all these directors, whoever gets there first approves it
                    foreach($directors as $dir){
                        event(new RequestCreatedEvent($dir, $req->requestor));
                    }

                }else{
                    $this->notifyLastDirector($req); // for last level (2) approval
                }

            }
            else {
                $traceability_id = 'level_two_approver_id';
                $traceability_date = 'level_two_approval_date';
                $traceability_comments = 'level_two_approver_comments';
                // for an officer
                $this->notifyLastDirector($req);
            }
        }
        if ($field == 'finance_approval') {
            if ($req->getRequestorType() == 'manager') {
                $field = 'level_two_approval';
                $traceability_id = 'level_two_approver_id';
                $traceability_date = 'level_two_approval_date';
                $traceability_comments = 'level_two_approver_comments';
                $this->notifyLastDirector($req); // for last approval

            } else {
                $traceability_id = 'finance_approver_id';
                $traceability_date = 'finance_approval_date';
                $traceability_comments = 'finance_approver_comments';
                // for an officer
                $this->notifyDirector1($req);
            }
        }
        if ($field == 'level_three_approval') {
            if ($req->getRequestorType() == 'director') {
                $field = 'level_two_approval';
                $traceability_id = 'level_two_approver_id';
                $traceability_date = 'level_two_approval_date';
                $traceability_comments = 'level_two_approver_comments';
                // the end of a director request
            }else{
                $traceability_id = 'level_three_approver_id';
                $traceability_date = 'level_three_approval_date';
                $traceability_comments = 'level_three_approver_comments';
                // for an officer
                // $this->notifyLastDirector($req);
            }
        }

        $trail = $req->trail;
        $trail[$field] = true;
        $trail[$traceability_id] = $request->user()->id;
        $trail[$traceability_date] = date('d-M-Y H:i');
        $trail[$traceability_comments] = $comments;
        $trail->save();

        // event(new RequestUpdateEvent($req->requestor));

        return $this->sendResponse('success', 'success');
    }

    public function notifyFinanceManager($request)
    {

        // send these to finance manager for approval

        foreach (Department::where('name', 'Finance and Operations')->first()->users as $user) {

            if (in_array('manager', $user->arrayOfRoles())) {
                $finance_manager = $user;
            }
        }

        event(new RequestCreatedEvent($finance_manager, $request->requestor));
    }
    public function notifyDirector1($request)
    {

        // send these to finance manager for approval
        foreach (Department::find($request->department_id)->users as $user) {
            if (in_array('director', $user->arrayOfRoles())) {
                $director = $user;
            }
        }

        event(new RequestCreatedEvent($director, $request->requestor));
    }
    public function notifyLastDirector($req)
    {

        // send these to finance manager for approval

        $desi = Designation::where('name', 'Executive Director')->value('id');

        event(new RequestCreatedEvent(User::where('designation_id', $desi)->first(), $req->requestor));
    }

    public function notifyLevelOne($request)
    {

        $requestor = User::find($request->user_id);
        $dept = $requestor->department_id;
        $requestor_type = $request->getRequestorType();

        if ($requestor_type == 'officer') {
            // notify your line manager who is your supervisor
            foreach (Department::find($dept)->users as $user) {
                if (in_array('manager', $user->arrayOfRoles())) {
                    $supervisor = $user;
                }
            }
            event(new RequestCreatedEvent($supervisor, $requestor));
        }

        if ($requestor_type == 'manager') {
            // you are a manager
            // notify your line director
            foreach (Department::find($dept)->users as $user) {
                if (in_array('director', $user->arrayOfRoles())) {
                    $director = $user;
                }
            }
            event(new RequestCreatedEvent($director, $requestor));
        }

        if ($requestor_type == 'director') {
            // you are a director
            // notify finance director, a user in finance dept and has director role
            $dept = Department::where('name', 'Finance and Operations')->value('id');
            foreach (Department::find($dept)->users as $user) {
                if (in_array('director', $user->arrayOfRoles())) {
                    $director = $user;
                }
            }
            event(new RequestCreatedEvent($director, $requestor));
        }
    }
}
