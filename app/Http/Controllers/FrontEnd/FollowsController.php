<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function accept($id){

        $p = Profile::where('id' ,Auth::id())->first();

        $p->followers()->updateExistingPivot($id , array('status' => 1) , false);


        return response()->json($p);
    }



    public function unFollow(User $user){

        return auth()->user()->following()->detach($user->profile);
    }
}
