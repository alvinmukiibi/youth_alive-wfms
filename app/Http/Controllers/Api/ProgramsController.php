<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Program;

class ProgramsController extends BaseController
{
    public function getPrograms(Request $request){
        $programs = Program::all();
        return $this->sendResponse($programs, 'All programs');
    }

    public function store(Request $request){

        $program = [
            'text' => $request->text,
            'value' => $request->text,
        ];

        $program = Program::create($program);

        return $this->sendResponse($program, 'Program created!');

    }
    public function update(Program $program, Request $request){

        $program->text = $request->text;
        $program->value = $request->text;
        $program->save();

        return $this->sendResponse($program, 'Program saved!');

    }

    public function delete(Program $program){
        $program->delete();
        return $this->sendResponse($program, 'program deleted!');

    }

}
