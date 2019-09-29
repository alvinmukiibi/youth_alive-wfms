<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Message;
use App\Reply;
use App\User;

class MessagingController extends BaseController
{
    public function getChats(Request $request){
        $message = new Message;
        $message->user_id = auth()->user()->id;
        $conversations = $message->getConversations();
        return $conversations;
    }
}
