<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\Comment;
use App\Models\User;
use App\Notifications\UserNotification;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    { }

    public function replayComment(Request $request)
    {
        $reply = new Comment;
        $reply->body = $request->bodyReplay;
        $reply->user()->associate($request->user());
        $reply->parent_id = $request->comment_id;
        $post = Post::find($request->post_id);

        $post->comments()->save($reply);

        return response()->json($reply);
    }


    public function fetchComment($id)
    {
        $comment = Post::with('comments')->where('id', $id)->get();
        return response()->json($comment);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
//    public function store(Request $request)
//    {
//
//        $comment = Comment::create([
//            'user_id' => $request->user_id,
//            'parent_id' => null,
//            'body' => $request->bodyComment,
//            'post_id' => $request->post_id
//        ]);
//
//        return response()->json($comment);
//    }

    public function replayedComment($id)
    {
        $comment = Comment::with('replies')->where('id', $id)->get();

        return response()->json($comment);
    }

    public function store(Request $request)
    {
        $string = $request->bodyComment;

        $first = $string[0];

        if ($first == '@'){

            $str = '';
//            $sub = preg_split('/[, ]+/' , $a);

            $sub = substr( $string, 1 );

            $username = strtok($sub , " ");

            $comment = Comment::create([

                'user_id' => $request->user_id,
                'parent_id' => null,
                'body' =>  $string ,
                'post_id' => $request->post_id
            ]);
            $post = Post::find($request->post_id);

            $user = User::where('username' , $username)->first();

            $user->notify(new UserNotification($post,$comment , Auth::user()));

            return response()->json($user);
        }
        else {

            $comment = Comment::create([

                'user_id' => $request->user_id,
                'parent_id' => null,
                'body' =>  $string ,
                'post_id' => $request->post_id
            ]);
            return \response()->json($comment);

        }

//


//        return response()->json($first);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $comment = Comment::find($id);

        $comment_replay = Comment::where('parent_id' , $id);
        $comment_replay->delete();

        $comment->delete();

        return response()->json($comment);

    }
}
