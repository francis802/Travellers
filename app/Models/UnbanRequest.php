<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnbanRequest extends Model
{
    use HasFactory;

    public $timestamps  = false;

    protected $table = 'unban_request';

    protected $fillable = ['title', 'description', 'date', 'accept_appeal'];
}
