<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Help extends Model
{
    use HasFactory;

    public $timestamps  = false;

    protected $table = 'common_help';

    protected $fillable = ['title', 'description', 'date'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
