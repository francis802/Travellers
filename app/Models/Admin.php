<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admin';
    public $timestamps  = false;
    protected $primaryKey = 'user_id';

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}