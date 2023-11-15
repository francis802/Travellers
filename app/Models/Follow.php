<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends User{
    use HasFactory;
    protected $table = 'follows';
    public $timestamps  = false;

    protected $fillable = [
        'user1_id',
        'user2_id'
    ];
}


