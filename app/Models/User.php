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
use App\Models\Group;
use App\Models\LikePost;
use App\Models\LikeComment;
use App\Models\Member;
use App\Models\Owner;
use App\Models\BannedMember;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps  = false;

   
    protected $fillable = ['username', 'email', 'name', 'profile_private', 'profile_photo', 'tsvectors', 'country', 'password'];

    protected $hidden = ['password'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function isAdmin() {
        return count($this->hasOne('App\Models\Admin', 'user_id')->get());
    }

    public function isBanned() {
        return count($this->hasOne('App\Models\Banned', 'user_id')->get());
    }

    public function getFollowing() {
        return $this->belongsToMany(User::class, 'follows', 'user1_id', 'user2_id')->orderBy('name', 'asc');
    }

    public function getFollowers() {
        return $this->belongsToMany(User::class, 'follows', 'user2_id', 'user1_id')->orderBy('name', 'asc');
    }

    public function follows(int $id) {
        return Follow::where('user1_id', $this->id)
                    ->where('user2_id', $id)->exists();
    }

    public function following(int $id) {
        return Follow::where('user2_id', $this->id)
                    ->where('user1_id', $id)->exists();
    }
    
    public function requestFollowing(int $id) {
        return FollowRequest::where('user1_id', $this->id)
                            ->where('user2_id', $id)->exists();
    }
    
    public function ownPosts() {
        return $this->hasMany('App\Models\Post', 'author_id')->orderBy('date', 'desc');
    }

    public function myPosts() {
        $own = Post::select('*')->where('post.author_id', '=', $this->id);
         
        return $own->orderBy('date','desc');
    }
    
    public function followingPosts() {
        return Post::select('post.*')
            ->join('follows', 'follows.user2_id', '=', 'post.author_id')
            ->where('follows.user1_id', '=', $this->id)
            ->whereNotIn('post.author_id', [$this->id])
            ->orderBy('post.date', 'desc');
    }


    public function myGroups() {
        return Group::fromRaw('groups,members')
                ->where('members.user_id', $this->id)
                ->whereColumn('groups.id', 'members.group_id');
    }

    public function ownedGroups() {
        return Group::select('groups.*')
                ->join('owner', 'owner.group_id', '=', 'groups.id')
                ->where('owner.user_id', $this->id);
    }

    public function likedPost($post_id){
        return LikePost::where('user_id', $this->id)
                        ->where('post_id', $post_id)->exists();
    }

    public function likedComment($comment_id){
        return LikeComment::where('user_id', $this->id)
                        ->where('comment_id', $comment_id)->exists();
    }

    public function followRequestUsers() {
        return User::select('users.*')
                ->join('requests', 'requests.user1_id', '=', 'users.id')
                ->where('requests.user2_id', $this->id);
    }

    public function isMember($group_id) {
        return Member::where('user_id', $this->id)
                    ->where('group_id', $group_id)->exists();
    }

    public function isOwner($group_id) {
        return Owner::where('user_id', $this->id)
                    ->where('group_id', $group_id)->exists();
    }

    public function isBannedFrom($group_id) {
        return BannedMember::where('user_id', $this->id)
                    ->where('group_id', $group_id)->exists();
    }

    

}
