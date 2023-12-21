<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Group;
use App\Models\User;
use App\Models\Post;
use App\Models\Member;
use App\Models\Owner;
use App\Models\Admin;
use App\Models\Country;
use App\Models\Message;
use App\Events\AdminNotificationEvent;

class GroupController extends Controller
{

    public function create(){
        $parents = Group::getParentGroups()->get();
        return view('pages.createGroup', ['parents' => $parents]);
    }

    public function store(Request $request){

        DB::beginTransaction();
        $group = new Group();
        $group->description = $request->text;
        $group->save();
        
        DB::table('owner')->insert([
            'user_id' => Auth::user()->id,
            'group_id' => $group->id,
        ]);

        $country = new Country();
        $country->name = $request->country_title;
        $country->city_id = $request->group_id;
        $country->save();

        if (!isset($contentFound) && $_FILES["image"]["error"]) {
            $group->banner_pic = null;
        }
        else {
            ImageController::create($group->id, $request, "group");
            $group->banner_pic = "images/group/group-".$group->id.".".pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION);
        }

        $group->country_id = $country->id;
        $parentGroup = Group::where('country_id', '=', $request->group_id)->first();
        $group->subgroup_id = $parentGroup->id;

        $group->save();

        $admins = Admin::all();
        foreach($admins as $admin){
            DB::table('group_creation_notification')->insert([
                'time' => now(),
                'group_id' => $group->id,
                'notified_id' => $admin->id,
                'sender_id' => Auth::user()->id
            ]);
        }

        DB::commit();

        $allAdmins = Admin::all();
        foreach ($allAdmins as $admin) {
            $user = User::findOrFail($admin->user_id);
            broadcast(new AdminNotificationEvent($user));
        }
        
        return redirect('group/'.$group->id)->with('success', 'Post created! Wait for approval of an admin...');
    }

    public function delete(Request $request){
        $group = Group::findOrFail($request->id);
        /*$this->authorize('delete', Auth::user(), $group);*/
      
        ImageController::delete($group->id, 'group');
        $country = Country::find($group->country_id);
        $country->delete(); 
        return redirect('home')->with('success', 'Group successfully deleted');

    }

    public function show(int $id){
        $group = Group::findOrFail($id);
        if(is_null($group)){
            return redirect()->back();
        }

        $messengers = Message::recentMessengers();
        $sharedUsers = User::whereIn('id', array_keys($messengers))->get();
        $sharedUsers = $sharedUsers->reverse();
        $allUsers = User::all();
        foreach ($allUsers as $user) {
            if (!isset($recentMessagers[$user->id])) {
                $sharedUsers = $sharedUsers->merge([$user->id => $user]);
            }
        }

        $posts = $group->posts()->get();
        $subgroups = $group->subgroups()->get();
        $members = $group->members()->get();

        return view('pages.group', ['group' => $group, 'posts' => $posts, 'subgroups' => $subgroups, 'members' => $members, 'sharedUsers' => $sharedUsers]); 
    }
    
    public function edit(int $groupId){
        $group = Group::findOrFail($groupId);
        return view('pages.editGroup', [
            'group' => $group,
        ]);
    }

    public function update(Request $request, int $groupId){
        $group = Group::findOrFail($groupId);
        /*$this->authorize('update', $group);*/
        $group->description = $request->text;
        $group->update();
        if (!isset($contentFound) && $_FILES["image"]["error"]) {
            if($group->banner_pic !== null && $request->clicked_x === "true") {
                ImageController::delete($group->id, 'group');
                $group->banner_pic = null;
            }
        }
        else {
            if($group->banner_pic === null) {
                ImageController::create($group->id, $request, "group");
                $group->banner_pic = "images/group/group-".$group->id.".".pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION);
            }
            else{
                ImageController::update($group->id, $request, "group");
            }
        }
        $group->update();
        return redirect('group/'.$group->id)->with('success', 'Group successfully edited');
    }

    public function listMembers(int $id){
        $group = Group::findOrFail($id);
        $members = $group->members()->get();
        return view('pages.listMembers', ['members' => $members, 'group' => $group]);
    }

    public function join(int $group_id) {
        $group = Group::findOrFail($group_id);

        Member::insert([
            'user_id' => Auth::user()->id,
            'group_id' => $group->id,
        ]);

        $members = $group->members()->get();
        return response()->json(['group' => $group, 'members' => $members]);
    }

    public function leave(int $group_id) {
        $group = Group::findOrFail($group_id);

        Member::where('group_id', $group->id)
              ->where('user_id', Auth::user()->id)->delete();
    

        $members = $group->members()->get();
        return response()->json(['group' => $group, 'members' => $members]);
        
    }

    public function removeMember(int $group_id, int $user_id){
        $group = Group::findOrFail($group_id);

        Member::where('group_id', $group->id)
              ->where('user_id', $user_id)->delete();

        

        return response()->json(['user_id' => $user_id]);
    }

    public function upgradeToOwner(int $group_id, int $user_id){
        $group = Group::findOrFail($group_id);

        Member::where('group_id', $group->id)
              ->where('user_id', $user_id)->delete();

        Owner::insert([
            'user_id' => $user_id,
            'group_id' => $group->id,
        ]);

        return response()->json(['user_id' => $user_id]);
    }

    public function listSubgroups(int $id){
        $group = Group::findOrFail($id);
        $subgroups = $group->subgroups()->get();
        
        return view('pages.listSubgroups', ['subgroups' => $subgroups, 'group' => $group]);
    }
} 