<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use App\Models\Post;

class Tag extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    protected $table = 'tag';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['hashtag'];

    /**
     * Get the author of the post.
     */
    public function posts(): BelongsToMany
    {
        return $this
        ->belongsToMany(Post::class)
        ->withPivotValue('post_tag');
    }
    
}
