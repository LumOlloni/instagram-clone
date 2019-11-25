<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileValidation;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;


class ProfileController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
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
       
        $profile = Profile::find($id);

        if ($profile->id == Auth::user()->id) {
            return view('frontend.template.edit')->with('profile' , $profile);
        }
        else {
            return abort('403');
        }
     

       
      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileValidation $request, $id)
    {


        $profile = Profile::find($id);

        if ($profile->image_id == 1) {

            $profile->bio = $request->input('bio');
            $profile->image_id = 1;
            $profile->user->name = $request->input('name');
            $profile->uploadCreateImage('img', $profile, $request);

            $profile->user->username = $request->input('username');
            $profile->user->email = $request->input('email');
            $profile->push();

            return redirect()->back();
        } else if ($profile->image_id != 1) {

            $profile->bio = $request->input('bio');
            $profile->user->name = $request->input('name');
            $profile->uploadEditImage('img', $profile, $request);
            $profile->user->username = $request->input('username');
            $profile->user->email = $request->input('email');
            $profile->push();

            return redirect()->back();
        }
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
