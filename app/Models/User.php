<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Follow;
use App\Models\FollowRequest;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps  = false;

   
    protected $fillable = ['username', 'email', 'name', 'profile_private', 'tsvectors', 'country', 'password'];

    protected $hidden = ['password'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function isAdmin() {
        return count($this->hasOne('App\Models\Admin', 'user_id')->get());
    }

    public function getFollowers() {
        return $this->belongsToMany(User::class, 'follows', 'user1_id', 'user2_id')->orderBy('name', 'asc');
    }

    public function getFollowing() {
        return $this->belongsToMany(User::class, 'follows', 'user2_id', 'user1_id')->orderBy('name', 'asc');
    }

    public function follows(int $id) {
        return Follow::where('user2_id', $this->id)
                    ->where('user1_id', $id)->exists();
    }

    public function following(int $id) {
        return Follow::where('user1_id', $this->id)
                    ->where('user2_id', $id)->exists();
    }
    
    public function requestFollowing(int $id) {
        return FollowRequest::where('user2_id', $this->id)
                            ->where('user1_id', $id)->exists();
    }
    
    public function ownPosts() {
        return $this->hasMany('App\Models\Post', 'author_id')->orderBy('date', 'desc');
    }

    public function myPosts() {
        $own = Post::select('*')->where('post.author_id', '=', $this->id);
         
        return $own->orderBy('date','desc');
    }
}
