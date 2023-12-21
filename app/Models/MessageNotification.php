<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageNotification extends Model
{
    use HasFactory;
    protected $table = 'new_message_notification';
    public $timestamps  = false;

    protected $fillable = [
        'message_id', 'notification_type', 'notified_id', 'opened'
    ];

    public function post()
    {
        return $this->belongsTo(Message::class, 'message_id');
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