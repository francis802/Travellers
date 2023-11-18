<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowRequest extends Model{
    use HasFactory;
    protected $table = 'requests';
    public $timestamps  = false;

    protected $fillable = [
        'user1_id', 'user2_id'
    ];
}