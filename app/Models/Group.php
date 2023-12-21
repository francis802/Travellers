<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Member;
use App\Models\GroupOwner;
use App\Models\Post;

class Group extends Model
{
    use HasFactory;


    public $timestamps  = false;

    protected $table = 'groups';

    protected $fillable = ['description', 'banner_pic', 'country_id'];

    
    public function owners()
    {
        return $this->belongsToMany(User::class, 'owner', 'group_id', 'user_id');
    }
      

    public function members() {
        return $this->hasMany('App\Models\Member');
    }

    public function posts(){
        return $this->hasMany('App\Models\Post'); 
    }

    public function subgroups(){
        return Group::select('groups.*')->where('groups.subgroup_id', '=', $this->id);
    }

    public function parentGroup(){
        return $this->belongsTo('App\Models\Group', 'subgroup_id');
    }

    public function isMember(User $user){
        return $this->members()
                    ->where('user_id', $user->id)
                    ->exists();
    }

    public function isOwner(User $user){
        return $this->owners()
                    ->where('user_id', $user->id)
                    ->exists();
    }

    public function isSubgroup(){
        return $this->subgroup_id != null;
    }

    public function country(){
        return $this->belongsTo('App\Models\Country');
    }

    public function notifications(){
        return $this->hasMany(GroupNotification::class, 'group_id');
    }

    static public function getParentGroups(){
        return Group::select('groups.*')->where('groups.subgroup_id', '=', null);
    }
    
    
}
