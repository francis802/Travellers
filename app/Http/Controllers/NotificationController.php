<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller 
{
    public function show()
    {
        $followRequestUsers = Auth::user()->followRequestUsers()->get();
        return view('pages.notifications', ['followRequestUsers' => $followRequestUsers]);
    }
}
