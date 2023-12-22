<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use Illuminate\Http\Request;
use App\Models\Help;
use Illuminate\Support\Facades\DB;

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
        $faq->question = $request->input('question');
        $faq->answer = $request->input('answer');
        $faq->last_edited = date('Y-m-d H:i:s');
        if ($request->help_id) {
            $help = Help::findOrFail($request->help_id);
            $help->became_faq = true;
            $help->save();
        }
    
        $faq->save();

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
