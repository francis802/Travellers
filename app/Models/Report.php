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

    public function humanDate() {
        $createdTime = new DateTime($this->date);
        $currentTime = new DateTime();

        $timeDifference = $createdTime->diff($currentTime);

        if ($timeDifference->y > 0) {
            $timeAgo = $timeDifference->format('%y year(s) ago');
        } elseif ($timeDifference->m > 0) {
            $timeAgo = $timeDifference->format('%m month(s) ago');
        } elseif ($timeDifference->d > 0) {
            $timeAgo = $timeDifference->format('%d day(s) ago');
        } elseif ($timeDifference->h > 0) {
            $timeAgo = $timeDifference->format('%h hour(s) ago');
        } elseif ($timeDifference->i > 0) {
            $timeAgo = $timeDifference->format('%i minute(s) ago');
        } else {
            $timeAgo = 'just now';
        }

        return $timeAgo;
    }
}
