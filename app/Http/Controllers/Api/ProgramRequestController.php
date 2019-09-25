<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Resources\ProgramRequestResource;
use App\ProgramRequest;
use Illuminate\Support\Facades\Validator;
use App\Project;
use App\TravelScope;

class ProgramRequestController extends BaseController
{
    public function store(Request $request)
    {

        $user = auth()->user();

        $req = new ProgramRequest;
        $req->identity = $this->generateRequestIdentity($request);
        $req->activity_type = $request->activity_type;
        $req->project_id = $request->project_id;
        $req->department_id = $request->department_id;
        $req->documents = $request->documents;
        $req->user_id = $user->id;
        $req->save();

        $req = new ProgramRequestResource($req);
        return $this->sendResponse($req, 'Request saved');
    }

    public function savetsow(Request $request)
    {

        $req = ProgramRequest::find($request->request_id);

        $tsow = [
            'travellers' => $request->travellers ,
            'date_of_activity' => $request->date_of_activity ,
            'destination' => $request->destination ,
            'departure_point' => $request->departure_point ,
            'departure_date' => $request->departure_date ,
            'return_date' => $request->return_date ,
            'objectives' => $request->objectives ,
            'activities' => $request->activities ,
            'key_people_to_be_met' => $request->key_people ,
            'expected_deliverables' => $request->deliverables ,
        ];

        $tsow = $req->travelscope()->updateOrCreate(['program_request_id' => $request->request_id], $tsow);

        return $this->sendResponse($tsow, 'Travel Scope of Work data');

     }
    public function savevhr(Request $request)
    {

        $req = ProgramRequest::find($request->request_id);

        if($request->vehicle){
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
        if($request->hotel){
            $hot = [
                'hotel' => true,
                'purpose' => $request->purpose
            ];
            $hot = $req->vehiclehotel()->updateOrCreate(['program_request_id' => $request->request_id], $hot);

            foreach($request->bookings as $booking){

                $hot->hotelbooking()->create($booking);

            }

        }

        return $this->sendResponse('saved', 'Vehicle hotel request data');

     }










    public function random_strings($length_of_string)
    {
        $str_result = '0123456789YOUTHALIVEUGANDA';
        return substr(str_shuffle($str_result),  0, $length_of_string);
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
}
