<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $user = User::findOrFail($id);
        if(!$user) return redirect()->back();
        $followers = $user->getFollowers()->get();
        $following = $user->getFollowing()->get();
        $posts = $user->ownPosts()->get();
        $groups = $user->myGroups()->get();
        return view('pages.profile', ['user' => $user, 'followers' => $followers, 'following' => $following, 'posts' => $posts, 'groups' => $groups]);
    }

    public function edit()
    {   
        $this->authorize('edit', User::class);
        return view('pages.editUser', ['user' => Auth::user(), 
                                       'old' => ['name' => Auth::user()->name, 
                                                 'username' => Auth::user()->username,
                                                 'email' => Auth::user()->email, 
                                                 'country' => Auth::user()->country,
                                                 'private' => Auth::user()->profile_private ] ]);
    }


    public function update(Request $request) {

        $this->authorize('update', User::class);
            $user = Auth::user();

            $request->validate([
                'name' => 'max:255',
                'username' => 'unique:users,username,'.$user->id.'|max:255',
                'email' => 'email|unique:users,email,'.$user->id.'|max:255',
                'country' => 'max:255'
            ]);

            if($request->password) {
                $request->validate([
                    'password' => 'string|min:6|confirmed',
                ]);
                $user->password = bcrypt($request->password);
            }
            

            $user->name = $request->input('name');
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            
            $user->profile_private = null !== $request->input('private');
            $user->save();

            if (!isset($contentFound) && $_FILES["image"]["error"]) {
                if($user->profile_photo !== null && $request->clicked_x === "true") {
                    ImageController::delete($user->id, 'pfp');
                    $user->profile_photo = null;
                }
            }
            else {
                if($user->profile_photo === null) {
                    ImageController::create($user->id, $request, "pfp");
                    $user->profile_photo = "images/pfp/pfp-".$user->id.".".pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION);
                }
                else{
                    ImageController::update($user->id, $request, "pfp");
                }
            }

            $user->save();
            return redirect('user/'.$user->id)->withSuccess('User updated successfully!');
        }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $userId)
    {
        $user = User::findOrFail($userId);
        $this->authorize('delete', $user);
        $user->name = null;
        $user->username = null;
        $user->email = null;
        $user->password = null;
        $user->profile_photo = null;
        $user->profile_private = null;
        $user->is_deleted = true;
        $user->save();
        if(Auth::user()->id == $userId) {
            Auth::logout();
            return redirect('login');
        }
        else {
            return redirect('admin/users');
        }
    }

    public function userVerify(Request $request) {
        if (!Auth::check()) return null;
        $input = $request->get('search');
        $user = User::where('username', $input)
                      ->get()
                      ->last();
        return $user->id ?? -1;
    }

    public function listGroups(int $id)
    {
        $user = User::findOrFail($id);
        $groups = $user->myGroups()->get();
        return view('pages.listGroups', ['groups' => $groups]);
    }

    public function followUser(int $id) 
    {
        $user = User::findOrFail($id);
        
        if ($user->profile_private) {
            DB::table('requests')
            ->insert(['user1_id' => Auth::user()->id, 'user2_id' => $id]);
        }
        else {
            DB::table('follows')
            ->insert(['user1_id' => Auth::user()->id, 'user2_id' => $id]);
        }

        $followers = $user->getFollowers()->get();

        return response()->json(['user' => $user, 'followers' => count($followers)]);
    }

    public function unfollowUser(int $id) 
    {
        $user = User::findOrFail($id);
        
        if (Auth::user()->follows($id)) {
            DB::table('follows')
            ->where('user1_id', '=', Auth::user()->id)
            ->where('user2_id', '=', $id)
            ->delete();
        }
        else {
            DB::table('requests')
            ->where('user1_id', '=', Auth::user()->id)
            ->where('user2_id', '=', $id)
            ->delete();
        }

        $followers = $user->getFollowers()->get();

        return response()->json(['user' => $user, 'followers' => count($followers)]);
    }

    public function acceptUser(int $id) 
    {
        $user = User::findOrFail($id);

        DB::table('follows')
        ->insert(['user1_id' => $id, 'user2_id' => Auth::user()->id]);

        DB::table('requests')
        ->where('user1_id', '=', $id)
        ->where('user2_id', '=', Auth::user()->id)
        ->delete();

        return response()->json(['user' => $user]);
    }

    public function declineUser(int $id) 
    {
        $user = User::findOrFail($id);

        DB::table('requests')
        ->where('user1_id', '=', $id)
        ->where('user2_id', '=', Auth::user()->id)
        ->delete();

        return response()->json(['user' => $user]);
    }

    public function followers(int $id)
    {
        $user = User::findOrFail($id);
        $followers = $user->getFollowers()->get();
        return view('pages.followers', ['followers' => $followers, 'user' => $user]);
    }

    public function following(int $id)
    {
        $user = User::findOrFail($id);
        $following = $user->getFollowing()->get();
        return view('pages.following', ['following' => $following, 'user' => $user]);
    }

    public function removeFollower(int $id)
    {
        $user = User::findOrFail($id);
        $followers = Auth::user()->getFollowers()->get();

        DB::table('follows')
        ->where('user1_id', '=', $id)
        ->where('user2_id', '=', Auth::user()->id)
        ->delete();

        return response()->json(['user' => $user, 'followers' => count($followers)]);
    }

    public function userBlock(int $id){
        $user = User::findOrFail($id);

        if (Auth::user()->follows($id)) {
            DB::table('follows')
            ->where('user1_id', '=', Auth::user()->id)
            ->where('user2_id', '=', $id)
            ->delete();
        }

        if($user->follows(Auth::user()->id)) {
            DB::table('follows')
            ->where('user1_id', '=', $id)
            ->where('user2_id', '=', Auth::user()->id)
            ->delete();
        }

        DB::table('blocks')
        ->insert(['user1_id' => Auth::user()->id, 'user2_id' => $id]);

        return response()->json(['user_id' => $id]);
    }

    public function userUnblock(int $id){
        $user = User::findOrFail($id);

        DB::table('blocks')
        ->where('user1_id', '=', Auth::user()->id)
        ->where('user2_id', '=', $id)
        ->delete();

        return response()->json(['user_id' => $id]);
    }
    

}
