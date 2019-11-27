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

                        @if (Auth::user()->id == $profile->id)

                        @else
                            @if (Auth::user()->following->contains($profile->id) && $users)

                                <button data-id="{{$profile->id}}" id="unFollow" class="btn btn-primary " type="submit">UnFollow</button>
                            @elseif(!(Auth::user()->following->contains($profile->id)))
                                    <button data-id="{{$profile->id}}" id="follow" class="btn btn-primary " type="submit">Follow </button>
                            @else
                                <button data-id="{{$profile->id}}" id="unFollow" class="btn btn-secondary" type="submit">Request Sent  </button>
                            @endif
                        @endif

                         <p class="proile-rating">Photos : <span>{{ $profile->post->count() }}</span>
                             Follower:<span>{{$profile->profile->followers->count()}}</span> Following
                             <span> {{$profile->following->count()}} </span> </p>
                    </div>
                </div>
                <div class="col-md-2">
                    @if ($profile->id == Auth::user()->id)
                        <a href = "{{route('profile.edit' , $profile->id)}} "  type="submit" class="profile-edit-btn" name="btnAddMore" >Edit Profile</a>
                    @endif

                </div>
            </div>
    </div>
</main>
 @if ($profile->is_public == 1 || Auth::id() || (Auth::user()->following->contains($profile->id) && $users))
@if (count($posts) > 0)
<section class="mt-1">
    <div class="wrapper">
        @foreach ($posts as $item)
            <figure>
                <img data-id="{{$item->id}}" src="/storage/thumbnail/post_thumbnail/{{$item->images->path}}" class="post_image showImage" alt="Image 1">
            </figure>
        @endforeach
    </div>
</section>
@endif
     @else
        <h2 class="text-danger text-center">This Account Is Private</h2>
 @endif
@endsection
@section('scripts')

    <script>

        const button = document.getElementById('follow');
        const unFollow = document.getElementById('unFollow');

        console.log(unFollow);
        let user_id = 0;

        if (unFollow) {
              user_id = unFollow.getAttribute('data-id');
        }
        else if(button){
              user_id = button.getAttribute('data-id');
        }

        const profile = "{!! $profile->username !!}";

        const followUser = (e) => {

            axios.post(`/follow/${user_id}`)
            .then((result) => {
                window.location.href = `/profile/${profile}`;
                console.log(result);

            }).catch((err) => {
                console.log(err);
            });;
            e.preventDefault();
        }

        const UnfollowUser = (e) => {

            axios.post(`/unfollow/${user_id}`)
            .then((result) => {
                window.location.href = `/profile/${profile}`;
                console.log(result);

            }).catch((err) => {
                console.log(err);
            });;
            e.preventDefault();
        }

        if (button) {
            button.addEventListener('click' , followUser);
        }
        else if(unFollow){
            unFollow.addEventListener('click' , UnfollowUser);
        }

        const showImage = document.querySelectorAll('.showImage');

        showImage.forEach((element) => {

            element.addEventListener('click' , function (e) {
                const id = element.getAttribute('data-id');

                axios.get(`/post/${id}/edit`)
                .then((response) => {

                    window.location.href = `/post/${id}/edit`;
                })
                .catch(err => console.log(err));

                e.preventDefault();
            })
        })



    </script>

@endsection
