<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelpNotification extends Model
{
    use HasFactory;
    protected $table = 'common_help_notification';
    public $timestamps  = false;

    protected $fillable = [
        'common_help_id', 'notified_id', 'opened', 'time'
    ];

    protected $casts = [
        'time' => 'datetime',
    ];

    public function help()
    {
        return $this->belongsTo(Help::class, 'common_help_id');
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