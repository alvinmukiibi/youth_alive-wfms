<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Contract;

class ContractsController extends BaseController
{
    public function getContracts(Request $request){
        $contracts = Contract::all();
        return $this->sendResponse($contracts, 'All contracts');
    }
}
