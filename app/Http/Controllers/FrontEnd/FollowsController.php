<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class FollowsController extends Controller
{
    public function store(User $user)
    {
        if ($user->profile->is_public == 0) {

            return auth()->user()->following()->attach($user->profile, ['status' => 0] , false);
        }

        else if($user->profile->is_public == 1){

            return auth()->user()->following()->attach($user->profile, ['status' => 1] , false);
        }
    }
    

    public function unFollow(User $user){

        return auth()->user()->following()->detach($user->profile);
    }
}
