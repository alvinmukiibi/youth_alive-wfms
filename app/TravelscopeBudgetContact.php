<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TravelscopeBudget;
class TravelscopeBudgetContact extends Model
{
    protected $guarded = ['id'];

    public function travelscopebudget(){
        return $this->belongsTo(TravelscopeBudget::class, 'travelscope_budget_id');
    }
}
