<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Reply;
class Message extends Model
{
    protected $guarded = ['id'];

    protected $table = 'messages';

    public function sender(){
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function recipient(){
        return $this->belongsTo(User::class, 'recipient_id');
    }
    public function replies(){
        return $this->hasMany(Reply::class, 'message_id');
    }






}
