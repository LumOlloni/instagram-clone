@extends('frontend.layouts.app')

@section('content')
<main class="py-4">
<div class="container emp-profile">
        <form method="post">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-img">
                        <img src="/storage/image_users/{{$profile->profile->images->path}}" alt=""/>
                        <div class="file btn btn-lg btn-primary">
                            Change Photo
                            <input type="file" name="file"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="profile-head">
                                <h5>
                                   {{Auth::user()->name}}
                                </h5>
                                <h6>{{Auth::user()->profile->images->bio}}</h6>
                                <p class="proile-rating">Photos : <span>3</span> Follower: <span>50</span> Following <span>150</span> </p>
                                <p class="proile-rating"> <input class="form-control w-50" value="{{$profile->name}}" name="name"  type="text"> </p>
                                <p class="proile-rating"> <input class="form-control w-50" value=" {{$profile->email}} " name="email" type="text"> </p>
                                <p class="proile-rating"> <input class="form-control w-50" value=" {{$profile->profile->bio}}" name="bio"  type="text"> </p>
                       </div>
                </div>
                <div class="col-md-2">
                    <input type="submit" class="profile-edit-btn" name="btnAddMore" value="Edit Profile"/>
                </div>
            </div>
        </form>           
    </div>
</main>
@endsection