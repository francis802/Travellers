<?php

namespace App\Policies;

use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;
    

    public function editUser(User $user)
    {
      return $user->id == Auth::user()->id;
    }

    public function edit() 
    {
      return Auth::check();
    }


    public function follow() {
      return Auth::check();
    }

}