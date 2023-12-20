<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    public $timestamps  = false;

    protected $table = 'message';

    protected $fillable = ['time', 'content', 'sender_id', 'receiver_id'];

    protected $casts = [
        'time' => 'datetime',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    static function recentMessagers()
    {
        $user = Auth::user();
        $messages = Message::where('sender_id', $user->id)->orWhere('receiver_id', $user->id)->orderBy('time', 'desc')->get();
        $recentMessagers = [];
        foreach ($messages as $message) {
            $otherUserId = ($message->sender_id == $user->id) ? $message->receiver_id : $message->sender_id;
            if (!isset($recentMessagers[$otherUserId])) {
                $recentMessagers = [$otherUserId => []] + $recentMessagers;
            }
            $recentMessagers[$otherUserId][] = $message;
        }
        return $recentMessagers;
    }
}
