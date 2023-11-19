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
        $this->authorize('create', [Auth::user(),Post::class]);
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
    public function edit(int $postId)
    {
        $post = Post::findOrFail($postId);
        return view('pages.editPost', [
            'post' => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $postId)
    {
        $this->authorize('update', [Auth::user(),Post::find($postId)]);
        $post = Post::findOrFail($postId);
        $post->group_id = 1; // TODO: Change this to the group the user chose to upload the post to
        $post->text = $request->text;
        $post->date = date('Y-m-d H:i');
        $post->update();
        if (!isset($contentFound) && $_FILES["image"]["error"]) {
            if($post->media !== null) {
                ImageController::delete($post->id);
            }
            $post->media = null;
        }
        else {
            if($post->media === null) {
                ImageController::create($post->id, $request);
                $post->media = "images/post-".$post->id.".".pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION);
            }
            else{
                ImageController::update($post->id, $request);
            }
        }
        $post->update();
        return redirect('post/'.$post->id)->with('success', 'Post successfully edited');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $postId)
    {
        $this->authorize('delete', [Auth::user(),Post::find($postId)]);
        $post = Post::find($postId);
        
        ImageController::delete($post->id);
        $post->delete();
        return redirect('home/')->with('success', 'Post successfully deleted');
    }
}
