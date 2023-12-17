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
    public function index()
    {
        //
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
    public function show(Help $help)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Help $help)
    {
        //
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
