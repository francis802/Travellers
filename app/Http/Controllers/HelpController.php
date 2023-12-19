<?php

namespace App\Http\Controllers;

use App\Models\Help;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HelpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showHelps()
    {
        $openedHelps = Auth::user()->helpsOpened()->get();
        $closedHelps = Auth::user()->helpsClosed()->get();
        return view('pages.helps', ['openedHelps' => $openedHelps, 'closedHelps' => $closedHelps]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.createHelp');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $help = new Help();
        $help->title = $request->title;
        $help->description = $request->description;
        $help->user_id = Auth::user()->id;
        $help->date = date('Y-m-d H:i:s');

        $help->save();
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $helpId)
    {
        $help = Help::findOrFail($helpId);
        return view('pages.fullHelp', ['help' => $help]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function answer(int $helpId, Request $request)
    {
        $help = Help::find($helpId);
        $help->answer = $request->answer;
        $help->save();
        return redirect()->route('admin.helps');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Help $help)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Help $help)
    {
        //
    }
}
