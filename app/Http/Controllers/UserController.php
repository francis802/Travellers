<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
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
    public function show(int $id)
    {
        $user = User::find($id);
        if(!$user) return redirect()->back();
        $followers = $user->getFollowers()->get();
        $following = $user->getFollowing()->get();
        return view('pages.profile', ['user' => $user, 'followers' => $followers, 'following' => $following]);
    }

    public function edit()
    {   
        return view('pages.editUser', ['user' => Auth::user(), 
                                       'old' => ['name' => Auth::user()->name, 
                                                 'username' => Auth::user()->username,
                                                 'email' => Auth::user()->email, 
                                                 'private' => Auth::user()->profile_private ] ]);
    }


    public function update(Request $request) {

            $user = Auth::user();

            $request->validate([
                'name' => 'max:255',
                'username' => 'unique:users,username,'.$user->id.'|max:255',
                'email' => 'email|unique:users,email,'.$user->id.'|max:255',
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

            $user->save();
            return redirect('user/'.$user->id);
        }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
