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
                            {{$profile->name}}
                         </h5>
                         <h6>{{$profile->profile->bio}}</h6>
                            @if(!(Auth::user()->profile->following->contains($profile->id)))
                                <button data-id="{{$profile->id}}" id="follow" class="btn btn-primary" type="submit">Follow </button>
                            @endif
                            @if($acceptFollow_request != null && $acceptFollow_request  == 0)
                             <button  id="accept" class="btn btn-primary " type="submit">Accept Follow</button>
                            @endif

                            @if($status_ofFollowing == 1)
                                <button data-id="{{$profile->id}}" id="unFollow" class="btn btn-primary" type="submit">UnFollow</button>
                                 @elseif($status_ofFollowing != null || $status_ofFollowing == 0)
                                    <button data-id="{{$profile->id}}" id="unFollow" class="btn btn-secondary" type="submit">Request Sent</button>
                            @endif

                         <p class="proile-rating">Photos : <span>{{ $profile->post->count() }}</span>
                             Follower:<span>{{$profile->profile->followers->count()}}</span> Following
                                                     <span> {{$profile->profile->following->count()}} </span> </p>
                    </div>
                </div>
            </div>
    </div>
    @jquery
    @toastr_js
    @toastr_render
</main>
@if ($is_public || $status_ofFollowing == 1  )
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
     @else
        <h2 class="text-danger text-center">This Account Is Private</h2>
 @endif
@endsection
