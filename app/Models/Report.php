<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTime;

class Report extends Model
{
    use HasFactory;

    public $timestamps  = false;

    protected $table = 'report';

    protected $fillable = ['title', 'description', 'date', 'ban_infractor'];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function infractor()
    {
        return $this->belongsTo(User::class, 'infractor_id', 'id');
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id', 'id');
    }

    public function evaluater()
    {
        return $this->belongsTo(Admin::class, 'evaluater_id', 'user_id');
    }

    public function notifications()
    {
        return $this->hasMany(ReportNotification::class, 'report_id');
    }

}
