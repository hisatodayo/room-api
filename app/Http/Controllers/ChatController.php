<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\MessageCreated;

class ChatController extends Controller
{
    public function get_messages()
    {
        $messages = \App\Message::with(['user' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->get();
        return $messages;
    }

    public function create(Request $request)
    {
        $message = \App\Message::create([
            'user_id' => $request->user_id,
            'body' => $request->message
        ]);
        event(new MessageCreated($message));
    }
}
