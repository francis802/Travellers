<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin;

class NotificationController extends Controller 
{
    public function show()
    {
        
        $followRequestUsers = Auth::user()->followRequestUsers()->get();
        $followNotifications = Auth::user()->followNotifications()->get();
        $commentNotifications = Auth::user()->commentNotifications()->get();
        $postNotifications = Auth::user()->postNotifications()->get();

        $combinedCollection = collect($followNotifications)->merge($commentNotifications)->merge($postNotifications);

        // Ordene a coleção pelo atributo 'time'
        $allnotifications = $combinedCollection->sortByDesc('time')->values();

        $unseenNotifications = Auth::user()->unseenNotifications();
        return view('pages.notifications', ['followRequestUsers' => $followRequestUsers, 'followNotifications' => $followNotifications, 'allnotifications' => $allnotifications]);
    }

    public function unseenUpdate()
    {
        $unseenNotifications = Auth::user()->unseenNotifications();
        return response()->json($unseenNotifications);
    }


    public function ownedGroupsNotifications(int $id)
    {
        $ownedGroupsNotifications = Auth::user()->ownedGroupsNotifications()->get();
        return view('pages.groupsNotifications', ['notifications' => $ownedGroupsNotifications]);
    }
}
