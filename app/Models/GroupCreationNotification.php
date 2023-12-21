<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupCreationNotification extends Model
{
    use HasFactory;
    protected $table = 'group_creation_notification';
    public $timestamps  = false;

    protected $fillable = [
        'group_id', 'notified_id', 'opened', 'time'
    ];

    protected $casts = [
        'time' => 'datetime',
    ];

    public function report()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function notifiedUser()
    {
        return $this->belongsTo(Admin::class, 'notified_id');
    }

    public function senderUser()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}