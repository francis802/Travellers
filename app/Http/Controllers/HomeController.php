<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Group;


class HomeController extends Controller
{

    public function show()
    {
        $publicPosts = Post::publicPosts()->get();
        $followingPosts = Auth::user()->followingPosts()->get();
        return view('pages.home', ['publicPosts' => $publicPosts, 'followingPosts' => $followingPosts]);
    }

    public function followFirstGroup() {
        // Obtém os 12 grupos com mais membros
        $groups = Group::withCount('members')->orderByDesc('members_count')->take(12)->get();

        // Retorna a view com os grupos
        return view('pages.followFirstGroup', ['groups' => $groups]);
    }

}