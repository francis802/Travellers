<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Group;
use App\Models\User;
use App\Models\Post;
use App\Models\Member;

class GroupController extends Controller
{
    public function create(Request $request)
    {

        $request->validate([
            'name' => 'unique:groups,name|min:3|max:255',
            'description' => 'max:255'
        ]);

        $group = new Group();
        $group->owner_id = Auth::user()->id;
        $group->name = $request->name;
        /*$group->country_id = $request->country;*/
        $group->description = nl2br(TagController::parseContent($request->description,'desc',-1));
       

        $group->save();
        
        return redirect('group/'.$group->id)->with('success', 'Group successfully created');
    }

    public function show(int $id)
    {
        $group = Group::find($id);
        if(is_null($group)){
            return redirect()->back();
        }

        
        $posts = $group->posts()->get();
        $subgroups = $group->subgroups()->get();

        return view('pages.group', ['group' => $group, 'posts' => $posts, 'subgroups' => $subgroups]); 
    }
    

    
}
