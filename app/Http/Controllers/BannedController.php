<?php

namespace App\Http\Controllers;

use App\Models\Banned;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UnbanRequest;

class BannedController extends Controller
{
    public function banned()
    {
        $banned = Banned::findOrFail(Auth::user()->id);
        $time_since_ban = $banned->ban_date->diffForHumans();
        return view('pages.banned', ['banned' => $banned, 'time_since_ban' => $time_since_ban]);
    }

    public function appeal_unban()
    {
        return view('pages.appeal-unban');
    }

    public function submit_appeal_unban(Request $request)
    {

        $unbanRequest = new UnbanRequest();
        $unbanRequest->banned_user_id = Auth::user()->id;
        $unbanRequest->title = $request->title;
        $unbanRequest->description = $request->description;
        $unbanRequest->date = now();
        $unbanRequest->save();

        return redirect('/banned');
    }
}