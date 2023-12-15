<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowNotification extends Model
{
    use HasFactory;
    protected $table = 'follow_notification';
    public $timestamps  = false;

    protected $fillable = [
       'notification_type', 'notified_id', 'opened'
    ];

    public function notifiedUser()
    {
        return $this->belongsTo(User::class, 'notified_id');
    }

    public function senderUser()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}