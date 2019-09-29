<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Resources\ProgramRequestResource;
use App\Http\Resources\ProgramRequestResourceExtensive;
use App\ProgramRequest;

use App\Project;
use App\Department;
use App\Designation;
use App\User;
use App\Events\RequestCreatedEvent;
use App\Mail\ApprovalTokenMail;
use App\Token;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ProgramRequestController extends BaseController
{
    public function store(Request $request)
    {

        $user = auth()->user();

        $req = new ProgramRequest;
        $req->identity = $this->generateRequestIdentity($request->activity_type, $request->project_id);
        $req->activity_type = $request->activity_type;
        $req->project_id = $request->project_id;
        $req->department_id = $user->department->id;
        $req->documents = $request->documents;
        $req->doc_completion_status = $request->doc_completion_status;
        $req->user_id = $user->id;
        $req->save();

        $req->trail()->create(['requestor_id' => $user->id, 'request_id' => $req->id]);

        // let it be an action on the request, notify accountant
        $accountant = User::find(Project::find($req->project_id)->accountant);
        event(new RequestCreatedEvent($accountant, $user));

        $req = new ProgramRequestResourceExtensive($req);
        return $this->sendResponse($req, 'Request saved');
    }

    public function saveAttachments(Request $request){

        $req = ProgramRequest::find($request->request_id);

        if ($request->hasFile('attachments')) {
            foreach ($request->attachments as $file) {
                $originalName = $file->getClientOriginalName();
                $name = pathinfo($originalName, PATHINFO_FILENAME);
                $replaced = \str_replace(' ', '_', $name);
                $newName = $replaced . '_' . $this->random_strings(5) . '.' . $file->getClientOriginalExtension();
                $ref = Storage::disk('public')->putFileAs('attachments', $file, $newName);
                $req->attachments()->create(['reference' => $ref]);
            }
        }

        return $this->sendresponse('success', 'success');

    }

    public function changedoccompletionstatus(Request $request){

        $req = ProgramRequest::find($request->request_id);
        $req->doc_completion_status = $request->doc_completion_status;
        $req->save();
        $req = new ProgramRequestResourceExtensive($req);
        return $this->sendResponse($req, 'saved');
    }

    public function savetsow(Request $request)
    {

        $req = ProgramRequest::find($request->request_id);

        if(auth()->user()->id != $req->user_id){
            return $this->sendError('error', ['error' => 'You can\'t edit a request you didn\'t initiate, please use the notes section to add comments']);
        }

        $tsow = [
            'travellers' => $request->travellers,
            'date_of_activity' => $request->date_of_activity,
            'destination' => $request->destination,
            'departure_point' => $request->departure_point,
            'departure_date' => $request->departure_date,
            'return_date' => $request->return_date,
            'objectives' => $request->objectives,
            'activities' => $request->activities,
            'key_people_to_be_met' => $request->key_people_to_be_met,
            'expected_deliverables' => $request->expected_deliverables,
        ];

        $tsow = $req->travelscope()->updateOrCreate(['program_request_id' => $request->request_id], $tsow);

        return $this->sendResponse($tsow, 'Travel Scope of Work data');
    }
    public function savevhr(Request $request)
    {

        $req = ProgramRequest::find($request->request_id);

        if(auth()->user()->id != $req->user_id){
            return $this->sendError('error', ['error' => 'You can\'t edit a request you didn\'t initiate, please use the notes section to add comments']);
        }

        if ($request->vehicle) {
            $veh = [
                'vehicle' => true,
                'departure_date' => $request->departure_date,
                'return_date' => $request->return_date,
                'departure_venue' => $request->departure_venue,
                'reason' => $request->reason,
                'name_of_passengers' => $request->name_of_passengers,
            ];
            $veh = $req->vehiclehotel()->updateOrCreate(['program_request_id' => $request->request_id], $veh);
        }
        if ($request->hotel) {
            $hot = [
                'hotel' => true,
                'purpose' => $request->purpose
            ];
            $hot = $req->vehiclehotel()->updateOrCreate(['program_request_id' => $request->request_id], $hot);

            foreach ($request->bookings as $booking) {

                $hot->hotelbooking()->create($booking);
            }
        }

        return $this->sendResponse('saved', 'Vehicle hotel request data');
    }

    public function savebudget(Request $request)
    {

        $req = ProgramRequest::find($request->request_id);

        if(auth()->user()->id != $req->user_id){
            return $this->sendError('error', ['error' => 'You can\'t edit a request you didn\'t initiate, please use the notes section to add comments']);
        }

        $bgt = [
            'activity' => $request->activity,
            'date' => $request->date,
            'destination' => $request->destination,
            'purpose' => $request->purpose,
            'total' => $request->total,
            'comments' => $request->comments,
        ];
        $bgt = $req->travelscopebudget()->updateOrCreate(['program_request_id' => $request->request_id], $bgt);

        if (count($request->items) > 0) {
            foreach ($request->items as $item) {
                $bgt->travelscopebudgetitem()->create($item);
            }
        }
        if (count($request->contacts) > 0) {
            foreach ($request->contacts as $contact) {
                $bgt->travelscopebudgetcontact()->create($contact);
            }
        }

        return $this->sendResponse('saved', 'Travel Scope Budget Saved');
    }

    public function random_strings($length_of_string)
    {
        $str_result = '0123456789YOUTHALIVEUGANDA';
        return substr(str_shuffle($str_result),  0, $length_of_string);
    }

    public function generateRequestIdentity($activity_type, $project_id)
    {

        $activity_type = \strtoupper($activity_type);
        $activity = \substr($activity_type, 0, 2);

        $project = Project::find($project_id)->name;
        $project = \strtoupper($project);
        $project = \substr($project, 0, 3);

        $identity = $activity . '/' . $project . '/' . $this->random_strings(4);

        return $identity;
    }

    public function getMyRequests(Request $request)
    {

        $user = $request->user();

        $requests = $user->requests;
        $requests = ProgramRequestResourceExtensive::collection($requests);

        return $this->sendResponse($requests, 'All my requests');

    }

    public function getProjectRequests(Request $request)
    {

        $user = $request->user();

        $project_id = Project::where('accountant', $user->id)->value('id');
        $requests = Project::find($project_id)->requests;
        $requests = ProgramRequestResourceExtensive::collection($requests);

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
        $reque = ProgramRequestResourceExtensive::collection($reqs);

        return $this->sendResponse($reque, 'Requests for level 1 approval');
    }
    public function getFMRequests(Request $request)
    {
        // requests from an officer and a manager and has level one approval for each
        $requests = collect();
        foreach (ProgramRequest::all() as $req) {
            if ($req->trail->level_one_approval == 1 && $req->getRequestorType() == 'officer') {
                $requests->push($req);
            }
            if ($req->trail->level_one_approval == 1 && $req->getRequestorType() == 'manager') {
                $requests->push($req);
            }
        }
        $requests = ProgramRequestResourceExtensive::collection($requests);
        return $this->sendResponse($requests, 'Requests for finance approval');
    }


    public function getEDRequests(Request $request)
    {

        $reqs = collect();
        $requests = ProgramRequest::all();
        foreach ($requests as $req) {
            if ($req->trail->level_two_approval == 1) {
                $reqs->push($req);
            }
            // get requests made by directors, for level 2 which is the last approval
            if ($req->getRequestorType() == 'director' && $req->trail->level_one_approval == 1 /* && $req->trail->level_two_approval == 0 */) {
                $reqs->push($req);
            }
        }

        $reqs = ProgramRequestResourceExtensive::collection($reqs);
        return $this->sendResponse($reqs, 'Requests for ED approval');
    }

    public function getDirectorRequests(Request $request)
    {
        $reqs = collect();

        $user = $request->user();

        // requests in directors line of department
        $requests = collect();
        foreach($user->directorate->departments as $dept){
            foreach($dept->requests as $r){
                $requests->push($r);
            }
        }

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
        // $all = ProgramRequest::all();
        // foreach($all)

        // if the director is a finance director, then get director requests for level 1 approval
        $dept_id = Department::where('name', 'Finance and Operations')->value('id');
        if (auth()->user()->department_id == $dept_id) {
            $directorrequests = ProgramRequest::all();
            foreach ($directorrequests as $re) {
                if ($re->trail->accountant_approval == 1 && $re->getRequestorType() == 'director') {
                    $reqs->push($re);
                }
            }
        }

        $reqs = ProgramRequestResourceExtensive::collection($reqs);
        return $this->sendResponse($reqs, 'Requests for directors approval');
    }

    public function invalidateToken(request $request){

        $user = auth()->user();

        $token = Token::where(['initiator' => $user->id, 'request' => $request->request_id, 'type' => $request->approvalType])->latest()->first();

        if($token){
            if($token->status){
                return $this->sendError('error', ['error' => 'Token already used']);
            }
            if($token->token == $request->token){
                if(date('d-M-Y H:i:s') < date('d-M-Y H:i:s', strtotime($token->expiry_date))){
                    $token->status = true;
                    $token->save();

                    return $this->sendResponse('success', 'Token invalidated');
                }else{
                    return $this->sendError('error', ['error' => 'Token expired, please generate another one!']);
                }
            }else{
                return $this->sendError('error', ['error' => 'Token incorrect, please enter right token']);
            }
        }else{
            return $this->sendError('error', ['error' => 'Token does not exist, please generate a token']);
        }

    }

    public function generateToken(Request $request){

        $user = auth()->user();

        $data = [
            'token' => $this->random_strings(5),
            'request' => $request->request_id,
            'initiator' => $user->id,
            'type' => $request->ty,
            'expiry_date' => date('Y-m-d H:i:s', strtotime("+10 min"))
        ];

        $token = Token::create($data);

        $mail = new ApprovalTokenMail;
        $mail->token = $token;
        $mail->user = $user->fname;

        Mail::to($user->email)->send($mail);

        return $this->sendResponse('success', 'Confirmation token has been sent to your email!');
    }

    public function approveRequest(Request $request)
    {
        $req = ProgramRequest::find($request->request_id);
        $field = $request->field;
        if ($field == 'accountant_approval') {
            $traceability_id = 'accountant_id';
            $traceability_date = 'accountant_approval_date';
            event(new RequestCreatedEvent($req->requestor->supervisor(), $req->requestor));
        }
        if ($field == 'level_one_approval') {
            $traceability_id = 'level_one_approver_id';
            $traceability_date = 'level_one_approval_date';
            // for an officer
            $this->notifyFinanceManager($req);
        }

        if ($field == 'level_two_approval') {

            if ($req->getRequestorType() != 'manager' && $req->getRequestorType() != 'director') {
                $traceability_id = 'level_two_approver_id';
                $traceability_date = 'level_two_approval_date';
                // for an officer
                $this->notifyLastDirector($req);
            }

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
                if ($req->requestor->designation_id == 1) {
                    // notify all other directors
                    $directors = [];
                    $all_users = User::all();
                    foreach ($all_users as $user) {
                        // if the directors dont include the finance director and the executive director
                        if (in_array('director', $user->arrayOfRoles()) && $user->designation_id != 1 && $user->id != auth()->user()->id) {
                            $directors[] = $user;
                        }
                    }
                    // notify all these directors, whoever gets there first approves it
                    foreach ($directors as $dir) {
                        event(new RequestCreatedEvent($dir, $req->requestor));
                    }
                } else {
                    $this->notifyLastDirector($req); // for last level (2) approval
                }
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
            } else {
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
    public function notifyFinanceManager($request)
    {

        // send these to finance manager for approval

        foreach (Department::where('name', 'Finance and Operations')->first()->users as $user) {

            if (in_array('manager', $user->arrayOfRoles())) {
                $notified = $user;
            }
        }
        if(!$notified){
            $notified = User::first();
        }

        event(new RequestCreatedEvent($notified, $request->requestor));
    }
    public function notifyDirector1($request)
    {
        $notified = null;

        // get the director that heads the directorate where the dept of the requestor belongs
        $directorate_id = $request->requestor->department->directorate->id;
        $users = User::where(['department_id' => null, 'directorate_id' => $directorate_id])->get();
        foreach ($users as $user) {
            if (in_array('director', $user->arrayOfRoles())) {
                $notified = $user;
            }
        }
        if(!$notified){
            $notified = User::first();
        }

        event(new RequestCreatedEvent($notified, $request->requestor));
    }
    public function notifyLastDirector($req)
    {

        // send these to finance manager for approval

        $desi = Designation::where('name', 'Executive Director')->value('id');

        event(new RequestCreatedEvent(User::where('designation_id', $desi)->first(), $req->requestor));
    }
    public function declineRequest(Request $request)
    {
        $comments = $request->comments;
        $req = ProgramRequest::find($request->request_id);
        $field = $request->field;
        if ($field == 'accountant_approval') {
            $traceability_id = 'accountant_id';
            $traceability_date = 'accountant_approval_date';
            $traceability_comments = 'accountant_comments';
            // $this->notifyLevelOne($req);
        }
        if ($field == 'level_one_approval') {
            $traceability_id = 'level_one_approver_id';
            $traceability_date = 'level_one_approval_date';
            $traceability_comments = 'level_one_approver_comments';
            // for an officer
            // $this->notifyFinanceManager($req);
        }

        if ($field == 'level_two_approval') {

            if ($req->getRequestorType() != 'manager' && $req->getRequestorType() != 'director') {

                $traceability_id = 'level_two_approver_id';
                $traceability_date = 'level_two_approval_date';
                $traceability_comments = 'level_two_approver_comments';
                // for an officer
                // $this->notifyLastDirector($req);
            }
            if ($req->getRequestorType() == 'manager') {
                $field = 'level_one_approval';
                $traceability_id = 'level_one_approver_id';
                $traceability_date = 'level_one_approval_date';
                $traceability_comments = 'level_one_approver_comments';
                // $this->notifyFinanceManager($req); // for level two approval

            }
            if ($req->getRequestorType() == 'director') {
                $field = 'level_one_approval';
                $traceability_id = 'level_one_approver_id';
                $traceability_date = 'level_one_approval_date';
                $traceability_comments = 'level_one_approver_comments';

                // if requestor is the ED himself
                if ($req->requestor->designation_id == 1) {
                    // notify all other directors
                    $directors = [];
                    $all_users = User::all();
                    foreach ($all_users as $user) {
                        // if the directors dont include the finance director and the executive director
                        if (in_array('director', $user->arrayOfRoles()) && $user->designation_id != 1 && $user->id != auth()->user()->id) {
                            $directors[] = $user;
                        }
                    }
                    // notify all these directors, whoever gets there first approves it
                    foreach ($directors as $dir) {
                        // event(new RequestCreatedEvent($dir, $req->requestor));
                    }
                } else {
                    // $this->notifyLastDirector($req); // for last level (2) approval
                }
            }
        }
        if ($field == 'finance_approval') {
            if ($req->getRequestorType() == 'manager') {
                $field = 'level_two_approval';
                $traceability_id = 'level_two_approver_id';
                $traceability_date = 'level_two_approval_date';
                $traceability_comments = 'level_two_approver_comments';
                // $this->notifyLastDirector($req); // for last approval

            } else {
                $traceability_id = 'finance_approver_id';
                $traceability_date = 'finance_approval_date';
                $traceability_comments = 'finance_approver_comments';
                // for an officer
                // $this->notifyDirector1($req);
            }
        }
        if ($field == 'level_three_approval') {
            if ($req->getRequestorType() == 'director') {
                $field = 'level_two_approval';
                $traceability_id = 'level_two_approver_id';
                $traceability_date = 'level_two_approval_date';
                $traceability_comments = 'level_two_approver_comments';
                // the end of a director request
            } else {
                $traceability_id = 'level_three_approver_id';
                $traceability_date = 'level_three_approval_date';
                $traceability_comments = 'level_three_approver_comments';
                // for an officer
                // $this->notifyLastDirector($req);
            }
        }

        $trail = $req->trail;
        $trail[$field] = 2;
        $trail[$traceability_id] = $request->user()->id;
        $trail[$traceability_date] = date('d-M-Y H:i');
        $trail[$traceability_comments] = $comments;
        $trail->save();

        // event(new RequestUpdateEvent($req->requestor));

        return $this->sendResponse($trail, 'success');
    }

    public function cancelRequest(Request $request){

        $req = ProgramRequest::find($request->id);
        $req->update(['status' => 2]);
        return $this->sendResponse($request, 'Request has been cancelled');

    }

    public function getRequestAttachments(Request $request){
        $req = ProgramRequest::find($request->id);

        $atts = [];
        foreach($req->attachments as $att){
            $atts[] = explode('/', $att->reference)[1];
        }
        return $this->sendResponse($atts, 'Request attachments');
    }
}
