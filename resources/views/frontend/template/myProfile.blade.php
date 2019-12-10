@extends('frontend.layouts.app')

@section('content')
    <main class="py-4">
        <div class="container emp-profile">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-img">
                        <img src="/storage/image_users/{{$profile->images->path}}" alt=""/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="profile-head">
                        <a style="float: right" href="{{route('profile.edit' , $profile)}}" class="btn btn-primary">Edit Profile</a>
                        <h5 style="font-size: 35px;">
                            {{$profile->user->name}}
                        </h5>
                        <h6 style="font-size: 25px;">{{$profile->bio}}</h6>

                        <p style="font-size: 25px;"  class="proile-rating">Photos : <span style="font-size: 20px;">{{ $profile->user->post->count() }}</span>
                            Follower:<span style="font-size: 20px;">{{$profile->followers->count()}}</span> Following
                            <span style="font-size: 20px;"> {{$profile->following->count()}} </span> </p>
                    </div>
                </div>
            </div>
        </div>
        @jquery
        @toastr_js
        @toastr_render
    </main>
    @if (count($posts) > 0)
        <section class="mt-1">
            <div class="wrapper">
                @foreach($posts as $item)
                    <figure>
                        <img class="openModal" data-id="{{$item->id}}" src="/storage/thumbnail/post_thumbnail/{{$item->images->path}}" class="post_image showImage" alt="Image 1">
                    </figure>
                @endforeach
            </div>
        </section>
    @else
        <h2 class="text-danger text-center">No Post Here</h2>
    @endif
@endsection
@section('scripts')

@endsection
