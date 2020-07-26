<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\MessageCreated;

class ChatController extends Controller
{
    public function get_messages()
    {
        return \App\Message::orderBy('id', 'desc')->get();
    }

    public function create(Request $request)
    {
        $message = \App\Message::create([
            'body' => $request->message
        ]);
        event(new MessageCreated($message));
    }
}
