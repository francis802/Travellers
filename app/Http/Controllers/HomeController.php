<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;


class HomeController extends Controller
{

    public function show()
    {
        $publicPosts = Post::publicPosts()->get();
        $followingPosts = Auth::user()->followingPosts()->get();
        return view('pages.home', ['publicPosts' => $publicPosts, 'followingPosts' => $followingPosts]);
    }

}