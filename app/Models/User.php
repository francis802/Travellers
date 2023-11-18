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

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['username', 'email', 'name', 'profile_private', 'tsvectors', 'country', 'password'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

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
        return RequestFollow::where('user2_id', $this->id)
                            ->where('user1_id', $id)->exists();
    }
    
}
