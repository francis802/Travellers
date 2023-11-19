<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Post;


class HomeController extends Controller
{

    
    public function show()
    {
        $publicPosts = Post::publicPosts();
        return view('pages.home', ['publicPosts' => $publicPosts,]);
    }
}