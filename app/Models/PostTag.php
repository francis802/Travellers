<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Post;
use App\Models\Tag;

class PostTag extends Model
{
    use HasFactory;
    protected $table = 'post_tag';
    public $timestamps  = false;
    protected $primaryKey = null;
    public $incrementing = false;
    

    protected $fillable = [
        'post_id', 'tag_id'
    ];    

    public function post() {
        $this->belongsTo(Post::class);
    }

    public function tag() {
        $this->belongsTo(Tag::class);
    }
}
