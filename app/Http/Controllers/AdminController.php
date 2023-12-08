<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Group;
use App\Models\Report;
use App\Models\Help;
use App\Models\UnbanRequest;

class AdminController extends Controller
{
    public function show() {
        $this->authorize('show', Admin::class);
        return view('pages.admin');
    }

    public function show_users() {
        $this->authorize('show', Admin::class);
        $users = User::all();
        return view('pages.adminUsers', ['users' => $users]);
    }

    public function show_groups() {
        $this->authorize('show', Admin::class);
        $groups = Group::all();
        return view('pages.adminGroups', ['groups' => $groups]);
    }

    public function show_reports() {
        $this->authorize('show', Admin::class);
        $reports = Report::all();
        return view('pages.adminReports', ['reports' => $reports]);
    }

    public function show_helps() {
        $this->authorize('show', Admin::class);
        $helps = Help::all();
        return view('pages.adminHelps', ['helps' => $helps]);
    }

    public function show_unban_requests() {
        $this->authorize('show', Admin::class);
        $unban_requests = UnbanRequest::all();
        return view('pages.adminUnbanRequests', ['unban_requests' => $unban_requests]);
    }

}
