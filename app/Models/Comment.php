<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    protected $fillable = ['text', 'date', 'edited'];

    protected $casts = [
        'date' => 'datetime',
    ];

    /**
     * Get the author of the comment.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the post which the comment belongs to.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function likes()
    {
        return DB::table('users')
        ->join('like_comment', 'like_comment.user_id', '=', 'users.id')
        ->join('comments', 'like_comment.comment_id', '=', 'comments.id')
        ->where('comments.id', '=', $this->id)
        ->get();
    }

    public function notifications()
    {
        return $this->hasMany(CommentNotification::class, 'comment_id');
    }

    public function extractMentions(){
        preg_match_all('/@([\w.]+)/', $this->text, $matches);
        return $matches[1] ?? [];
    }
}
