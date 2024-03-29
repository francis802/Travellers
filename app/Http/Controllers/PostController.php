<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use App\Models\Tag;
use App\Models\PostTag;
use App\Events\UserNotificationEvent;

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
        $usergroups = Auth::user()->myGroups()->get();
        return view('pages.createPost' , ['usergroups' => $usergroups]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Post::class);
        $post = new Post();
        $post->author_id = Auth::user()->id;
        $post->group_id = $request->group_id;
        $post->text = $request->text;
        $postDescription = $request->text;
        $post->date = date('Y-m-d H:i');
        $post->save();
        if (!isset($contentFound) && $_FILES["image"]["error"]) {
            $post->media = null;
        }
        else {
            ImageController::create($post->id, $request, "post");
            $post->media = "images/post/post-".$post->id.".".pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION);
        }
        $post->save();

        // Parse text to get the tags
        $pattern = '/#(\w+)/';
        preg_match_all($pattern, $postDescription, $matches);
        $hashtags = $matches[1];
        foreach ($hashtags as $hashtag) {
            $tag = new Tag();
            if(Tag::where('hashtag', $hashtag)->first() == null){
                $tag->hashtag = $hashtag;
                $tag->save();
            }
            else {
                $tag = Tag::where('hashtag', $hashtag)->first();
            }
            PostTag::create([
                'post_id' => $post->id,
                'tag_id' => $tag->id
            ]);
        }

        return redirect('post/'.$post->id)->with('success', 'Post successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $postId)
    {
        $messengers = Message::recentMessengers();
        $sharedUsers = User::whereIn('id', array_keys($messengers))->get();
        $sharedUsers = $sharedUsers->reverse();
        $allUsers = User::all();
        foreach ($allUsers as $user) {
            if (!isset($recentMessagers[$user->id])) {
                $sharedUsers = $sharedUsers->merge([$user->id => $user]);
            }
        }
        $post = Post::findOrFail($postId);
        return view('pages.post', [
            'post' => $post,
            'sharedUsers' => $sharedUsers
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
        $post = Post::findOrFail($postId);
        $this->authorize('update', $post);
        $post->group_id = 1; // TODO: Change this to the group the user chose to upload the post to
        $post->text = $request->text;
        $post->date = date('Y-m-d H:i');
        $post->edited = true;
        $post->update();
        if (!isset($contentFound) && $_FILES["image"]["error"]) {
            if($post->media !== null && $request->clicked_x === "true") {
                ImageController::delete($post->id, "post");
                $post->media = null;
            }
        }
        else {
            if($post->media === null) {
                ImageController::create($post->id, $request, "post");
                $post->media = "images/post/post-".$post->id.".".pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION);
            }
            else{
                ImageController::update($post->id, $request, "post");
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
        $post = Post::findOrFail($postId);
        $this->authorize('delete', $post);
        
        ImageController::delete($post->id, "post");
        $post->delete();
        if(url()->previous() == url('post/'.$post->id)) {
            return redirect('home/')->with('success', 'Post successfully deleted');
        }
        else return response()->json($post);
    }

    public function like_post(int $postId)
    {
        $post = Post::findOrFail($postId);
        
        DB::table('like_post')
        ->insert(['post_id' => $post->id, 'user_id' => Auth::user()->id]);

        $likes = $post->likes();

        $user = User::findOrFail($post->author_id);
        broadcast(new UserNotificationEvent($user));
        
        return response()->json(['post' => $post, 'likes' => count($likes)]);
    }

    public function dislike_post(int $postId)
    {
        $post = Post::findOrFail($postId);
        
        DB::table('like_post')
        ->where('post_id', '=', $post->id)
        ->where('user_id', '=', Auth::user()->id)
        ->delete();

        $likes = $post->likes();

        return response()->json(['post' => $post, 'likes' => count($likes)]);
    }

    public function convertUsernamesToIds(int $id){
        $post = Post::findOrFail($id);

        $usernames = $post->extractMentions();
        $user_ids = [];
        
        foreach ($usernames as $username) {
            $user = User::where('username', $username)->first();

            if ($user) {
                $user_ids[$username] = $user->id;
            }
        }

        return response()->json(['user_ids' => $user_ids, 'postId' => $id]);
    }

}
