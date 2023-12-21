<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportNotification extends Model
{
    use HasFactory;
    protected $table = 'report_notification';
    public $timestamps  = false;

    protected $fillable = [
        'report_id', 'notified_id', 'opened', 'time'
    ];

    protected $casts = [
        'time' => 'datetime',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class, 'report_id');
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