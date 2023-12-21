<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppealNotification extends Model
{
    use HasFactory;
    protected $table = 'appeal_notification';
    public $timestamps  = false;

    protected $fillable = [
        'unban_request_id', 'notified_id', 'opened', 'time'
    ];

    protected $casts = [
        'time' => 'datetime',
    ];

    public function report()
    {
        return $this->belongsTo(UnbanRequest::class, 'unban_request_id');
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