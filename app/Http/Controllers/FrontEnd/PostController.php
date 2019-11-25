<?php

namespace App\Http\Controllers\FrontEnd;


use App\Models\Tag;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Models\Image;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostValidation;
use Intervention\Image\Facades\Image as Img;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = auth()->user()->following()->pluck('profiles.id');

        $post = Post::whereIn('user_id' , $users)->take(5)->get();
        return view('frontend.template.home')->with('post' , $post);
    }





    public function fetchPost(Request $request){
        $users = auth()->user()->following()->pluck('profiles.id');

        $limit = $request->get('limit');

        $start = $request->get('start');

        // $post = Post::with(['images','likes'])->offset($start)->limit( $limit)->get();
        $post = Post::whereIn('user_id' , $users)->with(['images','likes'])->offset($start)->limit( $limit)->get();


        return view('frontend.template.postList' , compact('post'));
        
        // Auth::user()->likes()->where('post_id', $p->id)->first() ? Auth::user()->likes()->where('post_id' , $p->id)->first()->like == 0 ? "You dislike  this post" : "Dislike" : "Dislike"
  
        // foreach($post as $p){

        //    echo 
        //         '
        //         <div class="card-group"> 
        //             <div class="card mt-4 col-md-4 mx-auto"> 
        //                 <a class="openModal" data-id="'.$p->id.'"><img  class="card-img-top" src="/storage/post_image/'.$p->images->path.'"> 
        //                 </a>
        //                 <div class="interaction">
        //                     <a data-id="'.$p->id.'" class="like" href="#"> '. print(Auth::user()->likes()->where('post_id' , $p->id)->first() ? Auth::user()->likes()->where('post_id' , $p->id)->first()->like == 1 ? 'You Like this post' : 'Like' : 'Like') .' </a>
        //                     <a data-id = "'.$p->id.'" class="like" href="#">'. print(Auth::user()->likes()->where('post_id' , $p->id)->first() ? Auth::user()->likes()->where('post_id' , $p->id)->first()->like == 0 ? 'You dislike this post' : 'Dislike' : 'Dislike') .'</a>
        //                 </div>
        //             </div>  
                   
        //     </div> ';
        //  }
        }

        public function postModal($id)
        {
            $post = Post::with(['images', 'user', 'tags', 'comments'])->where('id', $id)
                ->first();

            return response()->json($post);
        }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function create(){
    //     $tag = Tag::all();
    //     return view('frontend.template.post')->with('tag', $tag);
    // }

    public function createPost(){
        $tag = Tag::all();
        return view('frontend.template.post')->with('tag', $tag);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostValidation $request)
    {

        if ($request->hasFile('img')) {

            $files = $request->file('img');

            // for save original image
            $ImageUpload = Img::make($files);
            $originalPath = public_path('/storage/post_image/');
            $ImageUpload->resize(340, 340);

            $ImageUpload->save($originalPath . time() . $files->getClientOriginalName());

            // for save thumnail image
            $thumbnailPath = public_path('/storage/thumbnail/post_thumbnail/');
            $ImageUpload->resize(250, 125);
            $ImageUpload = $ImageUpload->save($thumbnailPath . time() . $files->getClientOriginalName());

            $files = time() . $files->getClientOriginalName();
        }

        $img = Image::create([
            'path' => $files,
            'section' => 'post',
        ]);


        $post = Post::create([
            'image_id' => $img->id,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);

        toastr()->success('Post Created Succefully');

        $post->images()->associate($img);

        $post->tags()->sync($request->tags, false);

        return redirect()->back();
    }

    public function like(Request $request)
    {

        // $count = 0;
        $post_id = $request->post_id;
        $isLike = $request->isLike === 'true';
        $update = false;
        $post = Post::find($post_id);

        if (!$post) {
            return null;
        }

        $user = Auth::user();

        $like = $user->likes()->where('post_id', $post_id)->first();

        if ($like) {

            $alreadyLike = $like;
            $update = true;
            if ($alreadyLike == $like) {
                $like->delete();
                return null;
            }
        } else {
            $like = new Like;
        }
        // $like = new Like;
        $like->like = $isLike;
        $like->user_id = $user->id;
        $like->post_id = $post->id;

        if ($update) {
            $like->update();
        } 
        else {
            $like->save();
        }
        // return response()->json($like);
        return null;
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
        //
    }
}
