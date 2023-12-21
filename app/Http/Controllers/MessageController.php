<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showMessages()
    {
        $messengers = Message::recentMessengers();
        $users = User::whereIn('id', array_keys($messengers))->get();
        return view('pages.messages', ['messengers' => $messengers, 'users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function showPrivateMessages(int $userId)
    {
        $user = User::findOrFail($userId);
        $messages = Message::where(function ($query) use ($user, $userId) {
            $query->where('sender_id', $user->id)
                ->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($user, $userId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', $user->id);
        })->orderBy('time', 'asc')->get();
        return view('pages.messagesUser', ['messages' => $messages, 'user' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function sendMessage(Request $request, int $userId)
    {
        //
    }

    public function sharePost(Request $request, int $userId)
    {
        $message = new Message();
        $message->sender_id = Auth::user()->id;
        $message->receiver_id = $userId;
        $message->content = $request->post_url;
        $message->time = now();
        $message->save();
        return response()->json(['success' => 'Post shared successfully!']);
    }

}
