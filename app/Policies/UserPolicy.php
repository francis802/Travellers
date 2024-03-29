<?php

namespace App\Policies;

use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;
    

    public function edit(User $user)
    {
      return $user->id == Auth::user()->id;
    }

    public function update() 
    {
      return Auth::check();
    }


    public function follow() {
      return Auth::check();
    }

    public function delete(User $user1, User $user2) {
      return $user1->id == $user2->id || $user1->isAdmin();
    }

}