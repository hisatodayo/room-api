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
        $inputs = $request->validate([
            'user_id' => 'required|integer',
            // 'photo' => 'nullable|file|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mp4v,mpg4,3gp|max:51200',
            'message' => 'required|string'
        ]);

        $image_path = '';
        if (isset($request->photo)) {
            $store_path = $request->photo->store('public/points_images');
            $image_path = basename($store_path);
        }
        $message = \App\Message::create([
            'user_id' => $request->user_id,
            'image_path' => $image_path,
            'body' => $request->message
        ]);
        event(new MessageCreated($message));
        return response()->json(['message' => $image_path], 200);
    }
}
