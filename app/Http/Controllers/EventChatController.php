<?php

namespace App\Http\Controllers;

use App\Events\ChatMessage;
use App\Models\Chat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class EventChatController extends Controller
{
    public function index(Request $request)
    {

        $chat = new Chat();

        $chat->message = $request['text'];
        $chat->user_id = $request['userId'];
        $chat->room_id = $request['roomId'];

        $chat->save();

        ChatMessage::dispatch($request->all());

        return response()->json([
            'Новое сообщение'
        ]);
    }
}
