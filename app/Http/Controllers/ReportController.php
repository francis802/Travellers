<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use App\Models\Banned;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Follow;
use App\Models\FollowRequest;
use App\Models\Admin;
use App\Events\UserNotificationEvent;

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
    public function create(int $infractorId)
    {
        $infractor = User::findOrFail($infractorId);
        return view('pages.report', ['infractor' => $infractor]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $report = new Report();
        $report->title = $request->title;
        $report->description = $request->description;
        $report->infractor_id = $request->infractor_id;
        $report->reporter_id =Auth::user()->id;
        $report->date = now();
        $report->save();
        $reporter = User::findOrFail(Auth::user()->id);
        $infractor = User::findOrFail($request->infractor_id);
        if($reporter->follows($infractor->id)) {
            Follow::where('user1_id', $reporter->id)->where('user2_id', $infractor->id)->delete();
        }
        if($infractor->follows($reporter->id)) {
            Follow::where('user1_id', $infractor->id)->where('user2_id', $reporter->id)->delete();
        }
        if($infractor->requestFollowing($reporter->id)) {
            FollowRequest::where('user1_id', $infractor->id)->where('user2_id', $reporter->id)->delete();
        }
        if($reporter->requestFollowing($infractor->id)) {
            FollowRequest::where('user1_id', $reporter->id)->where('user2_id', $infractor->id)->delete();
        }
        if(!$infractor->isBlocked($reporter->id)) {
            $reporter->blocks($infractor);
        }

        $admins = Admin::all();

        foreach ($admins as $admin) {
            $user = User::findOrFail($admin->user_id);
            broadcast(new UserNotificationEvent($user));
        }
        
        return redirect('/user/'. $request->infractor_id);
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
        $report = Report::findOrFail($reportId);
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
        $report = Report::findOrFail($reportId);
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
