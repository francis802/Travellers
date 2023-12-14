<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentNotification extends Model
{
    use HasFactory;
    protected $table = 'comment_notification';
    public $timestamps  = false;

    protected $fillable = [
        'comment_id', 'notification_type', 'notified_id', 'opened'
    ];

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id');
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