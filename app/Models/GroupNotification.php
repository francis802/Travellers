<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupNotification extends Model
{
    use HasFactory;
    protected $table = 'group_notification';
    public $timestamps  = false;

    protected $fillable = [
        'group_id', 'notification_type', 'notified_id', 'opened'
    ];

    public function notifiedUser()
    {
        return $this->belongsTo(User::class, 'notified_id');
    }

    public function senderUser()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}