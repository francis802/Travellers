<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\User;
use App\Models\Group;
use App\Models\Comment;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    protected $table = 'post';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['date', 'text', 'media', 'author_id', ' group_id', 'edited'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'datetime',
    ];


    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public static function publicPosts() {
        return Post::select('post.*')
        ->join('users', 'post.author_id', '=', 'users.id')
        ->where('users.profile_private', '=', false)
        ->orderBy('post.date', 'desc');
        
      }

    public function tags()
    {
        return $this
        ->belongsToMany(Tag::class)
        ->withPivot('post_tag');
    }

    public function likes()
    {
        return DB::table('users')
        ->join('like_post', 'like_post.user_id', '=', 'users.id')
        ->join('post', 'like_post.post_id', '=', 'post.id')
        ->where('post.id', '=', $this->id)
        ->get();
    }
}
