<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banned extends Model
{
    use HasFactory;

    public $timestamps  = false;

    protected $table = 'banned';

    protected $fillable = ['ban_date'];

    protected $casts = [
        'ban_date' => 'datetime',
    ];
}
