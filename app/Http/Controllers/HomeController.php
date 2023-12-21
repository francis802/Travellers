<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Message;


class HomeController extends Controller
{

    public function show()
    {
        $messengers = Message::recentMessengers();
        $sharedUsers = User::whereIn('id', array_keys($messengers))->get();
        $sharedUsers = $sharedUsers->reverse();
        $allUsers = User::all();
        foreach ($allUsers as $user) {
            if (!isset($recentMessagers[$user->id])) {
                $sharedUsers = $sharedUsers->merge([$user->id => $user]);
            }
        }
        $publicPosts = Post::publicPosts()->get();
        $followingPosts = Auth::user()->followingPosts()->get();
        return view('pages.home', ['publicPosts' => $publicPosts, 'followingPosts' => $followingPosts, 'sharedUsers' => $sharedUsers]);
    }

}