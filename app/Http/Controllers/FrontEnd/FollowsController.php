<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowsController extends Controller
{

    protected $profile;
    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
    }

    public function store(Request $request)
    {
        $id = $request->get('id');

        $user = Profile::where('id' , $id)->first();
        $profile = Profile::where('id' , Auth::id())->first();

        if ($user->is_public == 0) {

            return $profile->following()->attach( $user->id, ['status' => 0] , false);
        }

        else if($user->is_public == 1){

            return  $profile->following()->attach($id, ['status' => 1] , false);
        }
    }

    public function accept($id){

        $profile = Profile::where('id' , Auth::id())->first();

        $profile->followers()->updateExistingPivot($id , array('status' => 1) , false);

        return response()->json($profile);
    }

    public function unFollow(Request $request){

        $id = $request->get('id');

        $user = Profile::where('id' , $id)->first();
        $profile = Profile::where('id' , Auth::id())->first();


        return $profile->following()->detach($user->id) ? "success" :  $profile->followers()->updateExistingPivot($id , array('status' => 0) , false);
    }
}
