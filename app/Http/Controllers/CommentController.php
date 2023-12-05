<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
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
        $comment = new Comment();
        $comment->author_id = Auth::user()->id;
        $comment->comment_id = $request->comment_id;
        $comment->text = $request->text;
        $comment->date = date('Y-m-d H:i');
        $comment->save();
        return response()->json(['comment'=>$comment, 'author'=>Auth::user()->name]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $commentId)
    {
        $comment = Comment::find($commentId);
        $this->authorize('update', $comment);
        $comment->text = $request->text;
        $comment->save();
        return response()->json($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $commentId)
    {
        $comment = Comment::find($commentId);
        $this->authorize('delete', $comment);
        $comment->delete();
        return response()->json($comment);
    }

    public function like_comment(int $commentId)
    {
        $comment = Comment::find($commentId);
        
        DB::table('like_comment')
        ->insert(['comment_id' => $comment->id, 'user_id' => Auth::user()->id]);

        $likes = $comment->likes();
        
        return response()->json(['comment' => $comment, 'likes' => count($likes)]);
    }

    public function dislike_comment(int $commentId)
    {
        $comment = comment::find($commentId);
        
        DB::table('like_comment')
        ->where('comment_id', '=', $comment->id)
        ->where('user_id', '=', Auth::user()->id)
        ->delete();

        $likes = $comment->likes();

        return response()->json(['comment' => $comment, 'likes' => count($likes)]);
    }
}
