<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class GroupOwner extends Model
{
    use HasFactory;

    public $timestamps  = false;

    protected $table = 'owner';

    protected $fillable = ['user_id', 'group_id'];

    public function owner() {
        return User::find($this->user_id);
    }

    public function group() {
        return Group::find($this->group_id);
    }
}
