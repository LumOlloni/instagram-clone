@extends('frontend.layouts.app')
@section('style')
    @toastr_css
@endsection
@section('content')

<main class="py-4">
    <div class="container emp-profile">
        <form action="{{route('profile.update' , $profile->id)}}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-img">
                            <img src="/storage/image_users/{{$profile->images->path}}" alt=""/>
                            <div class="file btn btn-lg btn-primary">
                                Change Photo
                                <input type="file" name="img"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-head">
                                    <h5>
                                       {{Auth::user()->name}}
                                    </h5>
                                    <h6>{{Auth::user()->profile->images->bio}}</h6>
                                    <p class="proile-rating">
                                    <label for="" class="mb-2">Name</label>
                                    <input class="form-control w-50" value="{{$profile->user->name}}" name="name"  type="text"> </p>
                                    <p class="proile-rating">
                                        <label for="" class="mb-2">Username</label>
                                     <input class="form-control w-50" value=" {{$profile->user->username}} " name="username" type="text"> </p>
                                    <p class="proile-rating">
                                    <label for="" class="mb-2">Email</label>
                                    <input class="form-control w-50" value=" {{$profile->user->email}} " name="email" type="text"> </p>
                                    <p class="proile-rating">
                                        <label for="" class="mb-2">Bio</label>
                                    <input class="form-control w-50" value=" {{$profile->bio}}" name="bio"  type="text"> </p>
                           </div>
                    </div>
                    <div class="col-md-2">
                        <input type="submit" class="profile-edit-btn" name="btnAddMore" value="Edit Your Profile"/>
                    </div>
                </div>
            </form>
        </div>
        @jquery
        @toastr_js
        @toastr_render
    </main>
@endsection
@section('scripts')
    <script>
        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif

    </script>
@endsection
