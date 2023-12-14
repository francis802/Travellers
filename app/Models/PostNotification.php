<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostNotification extends Model
{
    use HasFactory;
    protected $table = 'post_notification';
    public $timestamps  = false;

    protected $fillable = [
        'post_id', 'notification_type', 'notified_id', 'opened'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function notifiedUser()
    {
        return $this->belongsTo(User::class, 'notified_id');
    }

    public function senderUser()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}