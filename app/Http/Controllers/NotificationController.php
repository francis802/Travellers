<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller 
{
    public function show()
    {
        
        $followRequestUsers = Auth::user()->followRequestUsers()->get();
        $followNotifications = Auth::user()->followNotifications()->get();
        $unseenNotifications = Auth::user()->unseenNotifications();
        return view('pages.notifications', ['followRequestUsers' => $followRequestUsers, 'followNotifications' => $followNotifications, ]);
    }

    public function unseenUpdate()
    {
        $unseenNotifications = Auth::user()->unseenNotifications();
        return response()->json($unseenNotifications);
    }
}
