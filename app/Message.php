<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Support\Facades\DB;

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



    public function getConversations(){

        $coll = array();
        $convs = DB::table($this->table)->where(["sender_id" => $this->user_id])->orWhere(["recipient_id" => $this->user_id])->orderBy('created_at','asc')->get();

        foreach($convs as $conv){
            $msg = DB::table('replies')->where(['message_id' => $conv->id, 'id' => DB::table('replies')->where('message_id', $conv->id)->max('id')])->get();

            if($conv->sender_id !== $this->user_id){
                $convst = DB::table('users')->where(['id' => $conv->sender_id])->get();
                $obj = ['conv' => $conv, 'msg' => $msg, 'otherUser' => $convst];
            }else if($conv->recipient_id !== $this->user_id){
                $convst = DB::table('users')->where(['id' => $conv->recipient_id])->get();
                $obj = ['conv' => $conv, 'msg' => $msg, 'otherUser' => $convst];
            }
            $coll[] = $obj;
        }

        return $coll;




    }


}
