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

        $users = User::with('following')
        ->whereHas('following', function($q) {

            $q->where('status', '=', 1);
        })
        ->first();

        return view('frontend.template.profile')->with(['profile' => $profile
        , 'users' => $users , 'posts' => $posts]);
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
