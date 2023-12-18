<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use App\Models\Banned;
use Illuminate\Http\Request;

class ReportController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function ban_user(int $reportId)
    {
        $report = Report::find($reportId);
        $report->ban_infractor = true;
        $banned = new Banned();
        $banned->user_id = $report->infractor_id;
        $banned->ban_date = now();
        $banned->save();
        $report->save();
        return redirect('/admin/reports');
    }

    /**
     * Update the specified resource in storage.
     */
    public function close_report(int $reportId)
    {
        $report = Report::find($reportId);
        $report->ban_infractor = false;
        $report->save();
        return redirect('/admin/reports');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        //
    }
}
