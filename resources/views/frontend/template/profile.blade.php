@extends('frontend.layouts.app')
@section('content')
<main class="py-4">
<div class="container emp-profile">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-img">
                        <img src="/storage/image_users/{{$profile->profile->images->path}}" alt=""/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="profile-head">
                        <h5>
                            {{Auth::user()->name}}
                         </h5>
                         <h6>{{Auth::user()->profile->images->bio}}</h6>
                         <p class="proile-rating">Photos : <span>3</span> Follower: <span>50</span> Following <span>150</span> </p>
                    </div>
                </div>
                <div class="col-md-2">
                    <a href = "{{route('profile.edit' , $profile->id)}} "  type="submit" class="profile-edit-btn" name="btnAddMore" >Edit Profile</a>
                </div>
            </div>      
    </div>
</main>
@endsection