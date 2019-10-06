<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Message;
class Reply extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'date:d-M-Y H:i'
    ];

    public function message(){
        return $this->belongsTo(Message::class, 'message_id');
    }
}
