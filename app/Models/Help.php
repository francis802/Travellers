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

    protected $casts = [
        'date' => 'datetime',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function notifications()
    {
        return $this->hasMany(HelpNotification::class, 'common_help_id');
    }
}
