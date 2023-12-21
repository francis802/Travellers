<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Group;
use App\Models\Post;
use App\Models\Message;


class SearchController extends Controller
{
    public function show(Request $request) {
        $messengers = Message::recentMessengers();
        $sharedUsers = User::whereIn('id', array_keys($messengers))->get();
        $sharedUsers = $sharedUsers->reverse();
        $allUsers = User::all();
        foreach ($allUsers as $user) {
            if (!isset($recentMessagers[$user->id])) {
                $sharedUsers = $sharedUsers->merge([$user->id => $user]);
            }
        }

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

        $postResults = Post::select('post.id', 'post.text', 'post.author_id', 'post.date')
            ->whereRaw("post.tsvectors @@ to_tsquery(?)", [$searchQuery])
            ->orderByRaw("ts_rank(post.tsvectors, to_tsquery(?)) DESC", [$searchQuery])
            ->get();

        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        if ($startDate != null && $endDate != null) {
            $temp = [];
            foreach ($postResults as $post) {
                if ($post->date >= $startDate && $post->date <= $endDate) {
                    $temp[] = $post;
                }
            }
            $postResults = $temp;
        }

        return view('pages.search', compact('input', 'userResults', 'groupResults', 'postResults', 'sharedUsers'))->render();
    }
}