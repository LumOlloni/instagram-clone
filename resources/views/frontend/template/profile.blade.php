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
    @jquery
    @toastr_js
    @toastr_render
</main>
 @if ($profile->is_public == 1 || Auth::id() || (Auth::user()->following->contains($profile->id) && $users))
@if (count($posts) > 0)
<section class="mt-1">
    <div class="wrapper">
        @foreach ($posts as $item)
            <figure>
                <img class="openModal" data-id="{{$item->id}}" src="/storage/thumbnail/post_thumbnail/{{$item->images->path}}" class="post_image showImage" alt="Image 1">
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


        $(document).ready(function () {

            $('.openModal').click(function(e){



                const tags = document.querySelectorAll('.tags');
                const user = '{!! Auth::id() !!}';


                const edit = document.getElementById('editButton');

                var post_id = $(this).data('id');


                $.ajax({
                    type:'GET',
                    url: `/post/${post_id}`,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    success:function(data){
                        let arr = '';
                        let commnet = '';

                        $('#img').attr('src' , `/storage/post_image/${data.images.path}`);

                        if (data.user_id ==  user) {

                            document.getElementById('edit_button').href = `/post/${post_id}/edit`;

                        }

                        console.log(data);
                        $('.modal-title').html(data.description);
                        data.tags.forEach(element => {
                            arr += `<div>
                        <p class="ml-2 text-primary col-md-4 ">${element.name}</p>
                    </div>
                    `;
                        });
                        data.comments.forEach(element => {

                            const bool = (element.user_id == user);
                            console.log(bool);

                            let deleteBtn = (bool ? ` <div class="col-md-3">
                                    <button onclick="myFunction(${element.id})" data-delete = "" id="deleteBtn"  class="mt-1 btn btn-danger deleteBtn ">Delete</button>
                                 </div>` : '');

                            commnet += `<li data-replay="${element.id}"  class="replayedComment list-group-item col-md-9">${element.body}</li><div class="accordion" id="accordionExample">
                              <div class="col-md-3">
                                <button id="reply" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"  class="mt-1 btn btn-primary ">Reply</button>
                              </div>
                                ${deleteBtn}
                              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                  <div class="input-group mb-3">
                                      <input id="bodyReplay"  type="text" class="form-control replay" placeholder="Replay Comment">
                                      <div class="input-group-append">
                                        <button data-comment="${element.id}" id="replayComment" type="submit" class="input-group-text replay  text-white bg-primary ">Save</button>
                                      </div>
                                    </div>
                              </div>
                          </div>`;

                        });
                        $('.tags').html(arr);
                        $('.fetchComment').html(commnet);

                        $('.replay').click(function () {
                            const comment_id = $(this).data('comment');
                            let body = '';
                            $("input[type='text']").each(function() {
                                body = body + $(this).val();
                            })

                            $.ajax({

                                type:"Post",
                                url:"/replayComment",
                                data:{
                                    bodyReplay:body,
                                    comment_id:comment_id,
                                    post_id:post_id
                                },
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success:function(data){
                                    console.log(data);
                                    toastr.success("You replay comment Successfully");
                                    body.value = '';
                                },
                                error:function(err){
                                    console.log(err);
                                }
                            });
                        });

                        $('.replayedComment').click(function(){

                            const comment_id = $(this).data('replay');

                            let output = '';
                            $.ajax({
                                type:"GET",
                                url:`/replayedComment/${comment_id}`,
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success:function(response){

                                    console.log(response[0].replies);
                                    const r = response[0].replies;
                                    r.forEach(element => {
                                        output += `<li class="list-group-item">${element.body}</li>`;
                                    });

                                    $('.listItem').html(output);

                                },
                                error:function(err){
                                    console.log(err);
                                }
                            });

                            $('#commentModal').modal('show');
                        })

                        $('#exampleModal').modal('show');
                    }
                })

                $('.comment').click(function (e) {
                    const bodyComment = document.getElementById('bodyComment');
                    const auth = "{{Auth::id()}}";

                    if (bodyComment.value == '') {
                        toastr.error("Empty Body Comment");
                        // console.log("Error ");
                    }
                    else {
                        let outPut = '';
                        $.ajax({
                            type:"Post",
                            url:"{{route('comment.store')}}",
                            data:{
                                user_id:auth,
                                post_id:post_id,
                                bodyComment:bodyComment.value
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success:function(data){

                                toastr.success("Comment created Successfully");
                                console.log(data);

                                // const bool = (data.user_id == user);
                                //
                                // let deleteBtn = (bool ? ` <div class="col-md-3">
                                //     <button onclick="myFunction(${data.id})" id="deleteBtn"  data-delete = "${data.id}"  class="mt-1 btn btn-danger deleteBtn">Delete</button>
                                //  </div>` : '');
                                //
                                //
                                //
                                //
                                // outPut += `<li data-replay="${data.id}"  class="replayedComment list-group-item col-md-9">${data.body}</li><div class="accordion" id="accordionExample">
                                //       <div class="col-md-3 parentElement">
                                //         <button id="reply" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"  class="mt-1 btn btn-primary ">Reply</button>
                                //       </div>
                                //         ${deleteBtn}
                                //       <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                //           <div class="input-group mb-3">
                                //               <input id="bodyReplay"  type="text" class="form-control replay" placeholder="Replay Comment">
                                //               <div class="input-group-append">
                                //                 <button data-comment="${data.id}" id="replayComment" type="submit" class="input-group-text replay  text-white bg-primary ">Save</button>
                                //               </div>
                                //             </div>
                                //       </div>
                                //   </div>`;


                                $('.ajaxFetchComment').html(outPut);
                                bodyComment.value = '';
                            },
                            error:function(err){
                                console.log(err);
                            }
                        });
                    }
                    e.preventDefault();
                });

                window.myFunction = (id) => {

                    $.ajax({
                        type:'DELETE',
                        url:`/comment/${id}`,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success:function (data) {
                            $('li').filter(`[data-replay=${data.id}]`).remove();
                            $('.parentElement').remove();


                            $('button').filter(`[data-comment=${data.id}]`).remove();

                            $('.replay').filter(`[data-comment=${data.id}]`);

                            $('#reply').remove();
                            $('#replayComment').remove();
                            $('#deleteBtn').remove();
                            console.log(data);
                            toastr.success("Comment Deleted Succefully");
                        },
                        error:function (err) {
                              console.log(err);
                        }
                    })
                };
            });


        });
    </script>

@endsection
