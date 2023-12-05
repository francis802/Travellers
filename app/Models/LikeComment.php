<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Comment;
use App\Models\User;

class LikeComment extends Model
{
    use HasFactory;
    protected $table = 'like_comment';
    public $timestamps  = false;

    protected $fillable = [
        'user_id', 'comment_id'
    ];    

    public function comment() {
        $this->belongsTo(Comment::class);
    }

    public function user() {
        $this->belongsTo(User::class);
    }
}
