<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\User; 

class AdminController extends Controller
{
    public function show() {
        $this->authorize('show', Admin::class);
        return view('pages.admin');
    }

}
