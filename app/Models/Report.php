<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    public $timestamps  = false;

    protected $table = 'report';

    protected $fillable = ['title', 'description', 'date', 'ban_infractor'];

    protected $casts = [
        'date' => 'datetime',
    ];
}
