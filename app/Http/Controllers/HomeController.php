<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

use App\Models\Group;

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
        $fyPosts = Post::fyPosts()->get();
        $followingPosts = Auth::user()->followingPosts()->get();
        return view('pages.home', ['fyPosts' => $fyPosts, 'followingPosts' => $followingPosts, 'sharedUsers' => $sharedUsers]);
    }

    public function followFirstGroup() {
        // Obtém os 12 grupos com mais membros
        $groups = Group::withCount('members')->orderByDesc('members_count')->take(12)->get();

        // Retorna a view com os grupos
        return view('pages.followFirstGroup', ['groups' => $groups]);
    }

    public function aboutUs() {
        return view('pages.aboutUs');
    }

    public function termsOfUse() {
        return view('pages.termsOfUse');
    }

}