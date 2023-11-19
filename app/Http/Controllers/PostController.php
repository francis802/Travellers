<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\User;

class PostController extends Controller
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
        return view('pages.createPost');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $post = new Post();
        $post->author_id = Auth::user()->id;
        $post->group_id = 1; // TODO: Change this to the group the user chose to upload the post to
        $post->text = $request->text;
        $post->date = date('Y-m-d H:i');
        $post->save();
        if (!isset($contentFound) && $_FILES["image"]["error"]) {
            $post->media = null;
        }
        else {
            ImageController::create($post->id, $request);
            $post->media = "images/post-".$post->id.".".pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION);
        }
        $post->save();
        return redirect('post/'.$post->id)->with('success', 'Post successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $postId)
    {
        $post = Post::findOrFail($postId);
        return view('pages.post', [
            'post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
