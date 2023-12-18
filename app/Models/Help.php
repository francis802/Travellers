<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use DateTime;

class Help extends Model
{
    use HasFactory;

    public $timestamps  = false;

    protected $table = 'common_help';

    protected $fillable = ['title', 'description', 'date'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
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
