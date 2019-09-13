<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Setting extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'receive_login_notifications' => 'boolean',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
