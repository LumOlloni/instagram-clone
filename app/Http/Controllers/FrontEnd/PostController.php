<?php

namespace App\Http\Controllers\FrontEnd;


use App\Models\Tag;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Models\Image;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostEdit;
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
        return view('frontend.template.home');
    }





    public function fetchPost(Request $request){

        $users = auth()->user()->following()
        ->where('status' , 1)
        ->pluck('profiles.id');

        $limit = $request->get('limit');

        $start = $request->get('start');

//        $post = Post::whereIn('user_id' , $users)->with(['images','likes' ,'user'])->offset($start)->limit( $limit)->get();
        $post = Post::whereIn('user_id' , $users)->with(['images','likes' ,'user'])->offset($start)->limit($limit)->get();

//        dd($post->images->path);

        return view('frontend.template.postList' , compact('post'));

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

        $post = Post::find($id);

        if ($post->user_id == Auth::user()->id) {
            $tag = Tag::all();

            return view('frontend.template.postEdit')->with(['post' => $post , 'tag' => $tag]);

        }
        else {
            return redirect()->back();
        }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostEdit $request, $id)
    {
         $post = Post::find($id);

         $post->description = $request->get('description');
         $post->user_id = Auth::id();
         $post->uploadEditImage('img' , $post ,$request );

         $post->update();

         $post->tags()->sync($request->tags);

         toastr()->success('Post Updated Succefully');

         return redirect()->back();


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        $image = Image::find($post->image_id);

        $post->tags()->detach();

        $post->deleteImage($post);

        $image->delete();

        $post->delete();


        return response()->json(['success' => 'true']);
    }
}
