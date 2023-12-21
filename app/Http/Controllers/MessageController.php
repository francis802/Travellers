<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Models\User;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showMessages()
    {
        $messagers = Message::recentMessagers();
        return view('pages.messages', ['messagers' => $messagers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function showPrivateMessages(int $userId)
    {
        $user = User::findOrFail($userId);
        $messages = Message::where('sender_id', $user->id)->orWhere('receiver_id', $user->id)->orderBy('time', 'asc')->get();
        return view('pages.messagesUser', ['messages' => $messages, 'user' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function sendMessage(Request $request)
    {
        $message = new Message();
        $message->content = $request->text;
        $message->sender_id = Auth::user()->id;
        $message->receiver_id = $request->user_id;
        $message->time = date('Y-m-d H:i');
        $message->save();

        return response()->json(['message'=>$message]);
    
    }

}
