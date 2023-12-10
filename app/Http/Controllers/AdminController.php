<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Group;
use App\Models\Report;
use App\Models\Help;
use App\Models\UnbanRequest;
use App\Models\Banned;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function show() {
        $this->authorize('show', Admin::class);
        return view('pages.admin');
    }

    public function show_users() {
        $this->authorize('show', Admin::class);
        $users = User::all();
        $groups = Group::all();
        return view('pages.adminUsers', ['users' => $users, 'groups' => $groups]);
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

    public function makeAdmin($id) {
        $user = User::find($id);
        $role = $user->isBanned() ? 'banned' : 'user';
        if($role == 'banned'){
            DB::table('banned')->where('user_id', $id)->delete();
        }
        $admin = new Admin();
        $admin->user_id = $id;
        $admin->save();
        
        return response()->json(['user' => $user, 'role' => $role]);
    }

    public function makeUser($id) {
        $user = User::find($id);
        $role = $user->isAdmin() ? 'admin' : 'banned';
        if($role == 'admin'){
            Admin::where('user_id', $id)->delete();
        }
        else if($role == 'banned'){
            Banned::where('user_id', $id)->delete();
        }
        
        return response()->json(['user' => $user, 'role' => $role]);
    }

    public function makeBanned($id) {
        $user = User::find($id);
        $role = $user->isAdmin() ? 'admin' : 'user';
        if($role == 'admin'){
            Admin::where('user_id', $id)->delete();
        }
        Banned::create(['user_id' => $id, 'ban_date' => date('Y-m-d H:i:s')]);
        
        return response()->json(['user' => $user, 'role' => $role]);
    }

}
