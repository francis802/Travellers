<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Help extends Model
{
    use HasFactory;

    public $timestamps  = false;

    protected $table = 'common_help';

    protected $fillable = ['title', 'description', 'date'];
}
