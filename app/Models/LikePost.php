<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Post;
use App\Models\User;

class LikePost extends Model
{
    use HasFactory;
    protected $table = 'like_post';
    public $timestamps  = false;

    protected $fillable = [
        'user_id', 'post_id'
    ];    

    public function post() {
        $this->belongsTo(Post::class);
    }

    public function user() {
        $this->belongsTo(User::class);
    }
}
