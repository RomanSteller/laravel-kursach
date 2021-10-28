<?php

namespace App\Http\Controllers;

use App\Events\ChatMessage;
use Illuminate\Http\Request;

class EventChatController extends Controller
{
    public function index(Request $request)
    {
        ChatMessage::dispatch($request->all());
    }
}
