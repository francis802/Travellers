<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class SearchController extends Controller
{
    public function show(Request $request) {
        $input = $request->input('query');
        $searchQuery = $request->input('query') ? $request->input('query').':*' : "*";

        $searchResults = User::select('users.id', 'users.name', 'users.username')
            ->whereRaw("users.tsvectors @@ to_tsquery(?)", [$searchQuery])
            ->orderByRaw("ts_rank(users.tsvectors, to_tsquery(?)) DESC", [$searchQuery])
            ->get();

        return view('pages.search', compact('input', 'searchResults'))->render();
    }

    
}