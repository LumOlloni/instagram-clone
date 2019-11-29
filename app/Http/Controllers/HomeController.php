<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
    public function profile($username)
    {

        $profile = User::where('username', $username)->first();


        $posts = Post::with('images')
        ->whereHas('images' , function($q){
            $q->where('section' , 'post');
        })
        ->where('user_id' , $profile->id)->get();


        $id = $profile->id;
        $auth = Auth::id();


        $existProfile = Profile::where('id',  Auth::id())->whereHas('followers', function ($q) use ($id) {
            $q->where('user_id', $id );
            $q->where('status' , 0);

        })->exists();

        $checkProfile = Profile::where('id', $id )->where('is_public' , 0)->whereHas('followers', function ($q) use ($id) {
            $q->where('user_id', $id );
            $q->where('status' , 0);

        })->exists();


        $followBack = Profile::where('id', $auth )->whereHas('followers', function ($q) use ($id) {
            $q->where('user_id', $id );
            $q->where('status' , 1);

        })->exists();




        $users = Profile::where('id' ,  $id)->whereHas('followers' , function ($q) use ($auth){
            $q->where('user_id' , $auth);
            $q->where('status' , 0);
        })
        ->exists();


        return view('frontend.template.profile')->with(['profile' => $profile
        , 'users' => $users , 'posts' => $posts , 'existProfile' => $existProfile , 'checkProfile' => $checkProfile , 'followBack' => $followBack] );
    }

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
//        return response()->json($users);


    }
}
