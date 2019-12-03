<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use function foo\func;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function profile($username) {

        $profile = User::where('username', $username)->first();

        $my_id = Auth::id();

        if($profile->profile->is_public == true) {
            $is_public = true;
        } else {
            $is_public = false;
        }

        $users_following = Profile::where('id' ,   $my_id)->with('following')->whereHas('following' , function ($q) use ($profile){
            $q->where('accepter_id' , $profile->id);
//                ->where('status' , 1);
        })
        ->first();



            if ($users_following != null){
                $status_ofFollowing = $users_following->following[0]->pivot->status;
            }
            else {
                $status_ofFollowing  = null;
            }

        $acceptFollow = Profile::where('id' ,   $my_id)->with('followers')->whereHas('followers' , function ($q) use ($profile){
            $q->where('accepter_id' , Auth::id());
        })->first();

         if ($acceptFollow != null){
             $acceptFollow_request = $acceptFollow->followers[0]->pivot->status;
//            dd($acceptFollow_request);
         }
         else {
             $acceptFollow_request = null;
         }



        $posts = Post::with('images')
        ->whereHas('images' , function($q){
            $q->where('section' , 'post');
        })
        ->where('user_id' , $profile->id)->get();


        return view('frontend.template.profile')
            ->with('profile', $profile)
            ->with('is_public', $is_public)
            ->with('acceptFollow_request' , $acceptFollow_request)
            ->with('status_ofFollowing',$status_ofFollowing)
            ->with('users' , $users_following )
            ->with('acceptFollow' , $acceptFollow)
            ->with('posts', $posts);
    }

//    public function profile2($username)
//    {
//
//        $profile = User::where('username', $username)->first();
//
//
//        $posts = Post::with('images')
//        ->whereHas('images' , function($q){
//            $q->where('section' , 'post');
//        })
//        ->where('user_id' , $profile->id)->get();
//
//
//        $id = $profile->id;
//        $auth = Auth::id();
//
//
//        $existProfile = Profile::where('id',  Auth::id())->whereHas('followers', function ($q) use ($id) {
//            $q->where('user_id', $id );
//            $q->where('status' , 0);
//
//        })->exists();
//
//        $checkProfile = Profile::where('id', $id )->where('is_public' , 0)->whereHas('followers', function ($q) use ($id) {
//            $q->where('user_id', $id );
//            $q->where('status' , 0);
//
//        })->exists();
//
//
//        $followBack = Profile::where('id', $auth )->whereHas('followers', function ($q) use ($id) {
//            $q->where('user_id', $id );
//            $q->where('status' , 1);
//
//        })->exists();
//
//
//
//
//        $users = Profile::where('id' ,  $id)->whereHas('followers' , function ($q) use ($auth){
//            $q->where('user_id' , $auth);
//            $q->where('status' , 0);
//        })
//        ->exists();
//
//
//        return view('frontend.template.profile')->with(['profile' => $profile
//        , 'users' => $users , 'posts' => $posts , 'existProfile' => $existProfile , 'checkProfile' => $checkProfile , 'followBack' => $followBack] );
//    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $users = User::where('name' , 'like' , "$search%" )
            ->orWhere('username' , 'like', "$search%")
        ->get();

        $output = '';

        if ($users){
            foreach ($users as $user) {
                $output .= '<li style="right: 45px;" class="list-group-item mb-2"><a href="profile/'. $user->username .'">'.$user->name.'</a></li>';
            }

            return $output;
        }
    }

    public function  myProfile($id){

        $profile = Profile::where('id' , $id)->first();

        if ($profile->id == Auth::id()){
            return view('frontend.template.myProfile')->with('profile' , $profile);
        }
        else {
            abort(403, 'Something went wrong');
        }


    }

}
