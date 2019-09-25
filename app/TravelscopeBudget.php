<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProgramRequest;
use App\TravelscopeBudgetItem;
use App\TravelscopeBudgetContact;
class TravelscopeBudget extends Model
{
    protected $guarded = ['id'];

    public function programrequest(){
        return $this->belongsTo(ProgramRequest::class, 'program_request_id');
    }
    public function travelscopebudgetitem(){
        return $this->hasMany(TravelscopeBudgetItem::class, 'travelscope_budget_id');
    }
    public function travelscopebudgetcontact(){
        return $this->hasMany(TravelscopeBudgetContact::class, 'travelscope_budget_id');
    }

}
