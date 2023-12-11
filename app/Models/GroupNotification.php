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
        'group_id', 'notification_type', 'notified_id', 'opened'
    ];
}