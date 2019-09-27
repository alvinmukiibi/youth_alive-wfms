<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Resources\ProgramRequestResource;
use App\Http\Resources\ProgramRequestResourceExtensive;
use App\ProgramRequest;
use Illuminate\Support\Facades\Validator;
use App\Project;
use App\Department;
use App\Events\RequestCreatedEvent;
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
        // $accountant = User::find(Project::find($req->project_id)->accountant);
        // event(new RequestCreatedEvent($accountant, $user));

        $req = new ProgramRequestResource($req);
        return $this->sendResponse($req, 'Request saved');
    }

    public function saveAttachments(Request $request){

        $req = ProgramRequest::find($request->request_id);

        if ($request->hasFile('attachments')) {
            foreach ($request->attachments as $file) {
                $ref = Storage::disk('public')->put('attachments', $file);
                $req->attachments()->create(['reference' => $ref]);
            }
        }

        return $this->sendresponse('success', 'success');

    }

    public function changedoccompletionstatus(Request $request){

        $req = ProgramRequest::find($request->request_id);
        $req->doc_completion_status = $request->doc_completion_status;
        $req->save();
        $req = new ProgramRequestResource($req);
        return $this->sendResponse($req, 'saved');
    }

    public function savetsow(Request $request)
    {

        $req = ProgramRequest::find($request->request_id);

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

        $project = Project::find($project_id)->value('name');
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
}
