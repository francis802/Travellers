<?php

namespace App\Policies;

use Illuminate\Support\Facades\Auth;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AdminPolicy
{
    use HandlesAuthorization;

    public function show() {
        return Auth::check() && Auth::user()->isAdmin() ? Response::allow()
        : Response::deny('You are not authorized to view this page');
    }   
}