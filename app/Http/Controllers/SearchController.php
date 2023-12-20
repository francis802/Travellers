<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Group;
use App\Models\Post;

class SearchController extends Controller
{
    public function show(Request $request) {
        $input = $request->input('query');
        $searchQuery = $request->input('query') ? $request->input('query').':*' : "*";

        $userResults = User::select('users.id', 'users.name', 'users.username')
            ->whereRaw("users.tsvectors @@ to_tsquery(?)", [$searchQuery])
            ->orderByRaw("ts_rank(users.tsvectors, to_tsquery(?)) DESC", [$searchQuery])
            ->get();

        $groupResults = Group::select('groups.id', 'groups.description')
            ->whereRaw("groups.tsvectors @@ to_tsquery(?)", [$searchQuery])
            ->orderByRaw("ts_rank(groups.tsvectors, to_tsquery(?)) DESC", [$searchQuery])
            ->get();

        $postResults = Post::select('post.id', 'post.text', 'post.author_id')
            ->whereRaw("post.tsvectors @@ to_tsquery(?)", [$searchQuery])
            ->orderByRaw("ts_rank(post.tsvectors, to_tsquery(?)) DESC", [$searchQuery])
            ->get();

        return view('pages.search', compact('input', 'userResults', 'groupResults', 'postResults'))->render();
    }

    
}