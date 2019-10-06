<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Resources\RepliesResource;
use App\Message;
use App\Reply;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
class MessagingController extends BaseController
{
    public function getChats(Request $request){

        $user = $request->user();

        $correspondences = [];

        $messages = Message::where(['sender_id' => $user->id])->orWhere(['recipient_id' => $user->id])->latest()->get();

        foreach($messages as $msg){

            $reply = $msg->replies()->latest()->first();

            if($msg->sender_id != $user->id){
                $correspondent = $msg->sender;
                $obj = ['reply' => $reply, 'correspondent' => $correspondent];
            }
            if($msg->recipient_id != $user->id){
                $correspondent = $msg->recipient;
                $obj = ['reply' => $reply, 'correspondent' => $correspondent];
            }

            $correspondences[] = $obj;

        }

        return $this->sendResponse($correspondences, 'My chats');


    }

    public function sendMessage(Request $request){
        $user = $request->user();

        $recipient_id = $request->recipient_id;
        $msg = $request->message;
        $attachment = null;

        if($request->hasFile('attachment')){
            $validator =  Validator::make($request->all(), [
                'attachment' => 'max:10240'
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation errors', ['error' => $validator->errors()->first()], 422);
            }

            $file = $request->file('attachment');
            $originalName = $file->getClientOriginalName();
            $name = pathinfo($originalName, PATHINFO_FILENAME);
            $replaced = \str_replace(' ', '_', $name);
            $newName = $replaced . '_' . $this->random_strings(5) . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('attachments', $file, $newName);
            $attachment = $newName;
        }

        $obj = Message::where(['sender_id' => $user->id, 'recipient_id' => $recipient_id]);

        // ->orWhere();

        if($obj->count()){

            $message = $obj->first();

            $correspondence = [
                'message' => $msg,
                'attachment' => $attachment,
                'recipient_id' => $recipient_id
            ];

            $message->replies()->create($correspondence);

        }else{

            $obj = Message::where(['sender_id' => $recipient_id, 'recipient_id' => $user->id]);

            if($obj->count()){

                $message = $obj->first();

                $correspondence = [
                    'message' => $msg,
                    'attachment' => $attachment,
                    'recipient_id' => $recipient_id
                ];

                $message->replies()->create($correspondence);


            }else{

                 // no prior correspondence

                $message = Message::create(['sender_id' => $user->id, 'recipient_id' => $recipient_id]);

                $correspondence = [
                    'message' => $msg,
                    'attachment' => $attachment,
                    'recipient_id' => $recipient_id
                ];

                $message->replies()->create($correspondence);

            }


        }

        return $this->sendResponse($message, 'success');
    }

    public function countUnread(Request $request){

        $user = $request->user();

        $count = Reply::where(['recipient_id' => $user->id, 'status' => 'unread'])->count();

        return $this->sendResponse(['count' => $count], 'Count of unread messages');
    }

    public function getSingleChat(Message $message){

        $replies = $message->replies()->orderBy('created_at', 'asc')->get();

        foreach($replies as $reply){
            $msg = Message::find($reply->message_id);
            if($msg->sender_id == $reply->recipient_id){
                $reply->sender_id = $msg->recipient_id;
            }else{
                $reply->sender_id = $msg->sender_id;
            }
        }

        $replies = RepliesResource::collection($replies);

        $message->replies()->where('recipient_id', auth()->user()->id)->update(['status' => 'read']);

        return $this->sendResponse($replies, 'Replies');
    }

    public function random_strings($length_of_string)
    {
        $str_result = '0123456789YOUTHALIVEUGANDA';
        return substr(str_shuffle($str_result),  0, $length_of_string);
    }
}
