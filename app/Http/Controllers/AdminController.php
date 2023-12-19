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
use App\Models\BannedMember;
use App\Models\Owner;
use App\Models\Member;
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
        $groups = Group::where('approved', null)->get();
        return view('pages.adminGroups', ['groups' => $groups]);
    }

    public function groupApproval(Request $request, int $groupId) {
        $group = Group::find($groupId);
        if($request->decision == 'true'){
            $group->approved = true;
            $group->save();
        }
        else if($request->decision == 'false'){
            Owner::where('group_id', $group->id)->delete();
            Member::where('group_id', $group->id)->delete();
            BannedMember::where('group_id', $group->id)->delete();
            $group->delete();
        }
        return response()->json(['group' => $group]);
    }

    public function show_reports() {
        $this->authorize('show', Admin::class);
        $openedReports = Report::where('ban_infractor', null)->get();
        $closedReports = Report::where('ban_infractor', '!=', null)->get();

        return view('pages.adminReports', ['openedReports' => $openedReports, 'closedReports' => $closedReports]);
    }

    public function show_helps() {
        $this->authorize('show', Admin::class);
        $openedHelps = Help::where('answer', null)->get();
        $closedHelps = Help::where('answer', '!=', null)->get();
        return view('pages.adminHelps', ['openedHelps' => $openedHelps, 'closedHelps' => $closedHelps]);
    }

    public function show_unban_requests() {
        $this->authorize('show', Admin::class);
        $openedAppeals = UnbanRequest::where('accept_appeal', null)->get();
        $closedAppeals = UnbanRequest::where('accept_appeal', '!=', null)->get();
        return view('pages.adminUnbanRequests', ['openedAppeals' => $openedAppeals, 'closedAppeals' => $closedAppeals]);
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
        $banned = new Banned();
        $banned->user_id = $id;
        $banned->ban_date = now();
        $banned->save();
        
        return response()->json(['user' => $user, 'role' => $role]);
    }

    public function groupMembershipOwner(int $group_id, int $user_id) {
        $user = User::find($user_id);
        $role = $user->isOwner($group_id) ? 'owner' : ($user->isBannedFrom($group_id) ? 'banned' :($user->isMember($group_id) ? 'member' : 'none'));
        $owner = new Owner();
        $owner->user_id = $user_id;
        $owner->group_id = $group_id;
        if($role == 'owner'){
            Owner::where('user_id', $user_id)->where('group_id', $group_id)->delete();
            Member::where('user_id', $user_id)->where('group_id', $group_id)->delete();
        }
        else if($role == 'banned'){
            BannedMember::where('user_id', $user_id)->where('group_id', $group_id)->delete();
            $owner->save();
        }
        else if($role == 'member'){
            Member::where('user_id', $user_id)->where('group_id', $group_id)->delete();
            $owner->save();
        }
        else if($role == 'none'){
            $owner->save();
        }
        return response()->json(['owner' => $owner, 'role' => $role]);
    }

    public function groupMembershipMember(int $group_id, int $user_id) {
        $user = User::find($user_id);
        $role = $user->isOwner($group_id) ? 'owner' : ($user->isBannedFrom($group_id) ? 'banned' : ($user->isMember($group_id) ? 'member' : 'none'));
        $member = new Member();
        $member->user_id = $user_id;
        $member->group_id = $group_id;
        if($role == 'owner'){
            Owner::where('user_id', $user_id)->where('group_id', $group_id)->delete();
        }
        else if($role == 'banned'){
            BannedMember::where('user_id', $user_id)->where('group_id', $group_id)->delete();
            $member->save();
        }
        else if($role == 'member'){
            Member::where('user_id', $user_id)->where('group_id', $group_id)->delete();
        }
        else if($role == 'none'){
            $member->save();
        }
        return response()->json(['member' => $member, 'role' => $role]);
    }

    public function groupMembershipBanned(int $group_id, int $user_id) {
        $user = User::find($user_id);
        $role = $user->isOwner($group_id) ? 'owner' : ($user->isBannedFrom($group_id) ? 'banned' : ($user->isMember($group_id) ? 'member' : 'none'));
        $banned = new BannedMember();
        $banned->user_id = $user_id;
        $banned->group_id = $group_id;
        if($role == 'owner'){
            Owner::where('user_id', $user_id)->where('group_id', $group_id)->delete();
            Member::where('user_id', $user_id)->where('group_id', $group_id)->delete();
            $banned->save();
        }
        else if($role == 'banned'){
            BannedMember::where('user_id', $user_id)->where('group_id', $group_id)->delete();
        }
        else if($role == 'member'){
            Member::where('user_id', $user_id)->where('group_id', $group_id)->delete();
            $banned->save();
        }
        else if($role == 'none'){
            $banned->save();
        }
        return response()->json(['banned' => $banned, 'role' => $role]);
    }
}
