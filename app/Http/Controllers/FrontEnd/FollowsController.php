<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class FollowsController extends Controller
{
    public function store(User $user)
    {
        return auth()->user()->following()->attach($user->profile, ['status' => 1] , false);
    }
    

    public function unFollow(User $user){

        return auth()->user()->following()->detach($user->profile);
    }
}
