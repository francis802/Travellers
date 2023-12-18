<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use Illuminate\Http\Request;
use App\Models\Help;

class FAQController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showFAQs()
    {
        $faqs = FAQ::all()->sortByDesc('last_edited');
        return view('pages.faqs', ['faqs' => $faqs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $faq = new FAQ();
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->last_edited = date('Y-m-d H:i:s');
        $help = Help::find($request->help_id);
        $help->became_faq = true;
    
        $faq->save();
        $help->save();
        return redirect()->route('faqs');
    }

    /**
     * Display the specified resource.
     */
    public function show(FAQ $fAQ)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FAQ $fAQ)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FAQ $fAQ)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FAQ $fAQ)
    {
        //
    }
}
