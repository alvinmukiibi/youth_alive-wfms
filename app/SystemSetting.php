<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'good_friday' => 'date:Y-m-d',
        'easter_sunday' => 'date:Y-m-d',
        'easter_monday' => 'date:Y-m-d',
        'eid_ul_fitr' => 'date:Y-m-d',
        'eid_al_adha' => 'date:Y-m-d',
        'other_holiday' => 'date:Y-m-d',
    ];
}
