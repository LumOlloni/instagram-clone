@extends('frontend.layouts.app')

@section('style')
    @toastr_css
@endsection

@section('content')

  <main class="py-4">
    <h2 class="text-center">Photo of Users</h2>
      <div class="container element"> 
          @forelse ($post as $item)
          <div class="card-group"> 
                <div  class="card mt-4 col-md-4 mx-auto"> 
                    <a  class="openModal" data-id="{{$item->id}}"><img  class="card-img-top" src="/storage/post_image/{{$item->images->path}}"> 
                    </a>
                    <div class="interaction">
                        <a data-id="{{$item->id}}" class="like" href="#"> {{Auth::user()->likes()->where('post_id' , $item->id)->first() ? Auth::user()->likes()->where('post_id' , $item->id)->first()->like == 1 ? 'You Like this post' : 'Like' : 'Like'}} </a>

                        <a data-id = "{{$item->id}}" class="like" href="#"> {{Auth::user()->likes()->where('post_id' , $item->id)->first() ? Auth::user()->likes()->where('post_id' , $item->id)->first()->like == 1 ? 'You dislike  this post' : 'Dislike' : 'Dislike'}} </a>
                      </div>
                      {{-- <p>{{$item->likes()->count()}}</p> --}}
                </div> 
                
          </div> 
          @empty
          <h2>No Post Here</h2>   
          @endforelse
      </div>
      @jquery
      @toastr_js
      @toastr_render 
  </main>
<br><br>    
@endsection
@section('scripts')

    <script src="{{asset('js/like.js')}}"></script>
    <script>

    $(document).ready(function(){
      $('.openModal').click(function(){
        const tags = document.querySelectorAll('.tags');
      
        const post_id = $(this).data('id');
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
              console.log(data);
              $('.modal-title').html(data.description);
              data.tags.forEach(element => {
                arr += `<div>
                        <p class="ml-2 text-primary col-md-4 ">${element.name}</p>
                    </div>
                    `;
              });
              data.comments.forEach(element => {
                commnet += `<li data-replay="${element.id}"  class="replayedComment list-group-item col-md-9">${element.body}</li><div class="accordion" id="accordionExample">
                  <div class="col-md-3">
                    <button id="reply" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"  class="mt-1 btn btn-primary ">Reply</button>
                  </div>
                  <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                      <div class="input-group mb-3">
                          <input id="bodyReplay"  type="text" class="form-control replay" placeholder="Replay Comment">
                          <div class="input-group-append">
                            <button data-comment="${element.id}" id="replayComment" type="submit" class="input-group-text replay  text-white bg-primary ">Save</button>
                          </div>
                        </div>
                  </div>
              </div>`    
               
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

        $('.comment').submit(function (e) {
        const bodyComment = document.getElementById('bodyComment');
        const auth = "{{Auth::id()}}";

        if (bodyComment.value == '') {
            toastr.error("Empty Body Comment");
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
            console.log(data);

            toastr.success("Comment created Successfully");
            bodyComment.value = '';
          },
          error:function(err){
            console.log(err);
          }
        });
      }
        e.preventDefault();
      });


      });

      let post = 0;

      $('.like').on('click', function (event) {
        
        const post_id = $(this).data('id');

        const isLike = event.target.previousElementSibling == null;

        $.ajax({
            method: 'POST',
            url: '/likePost',
            data: {
              isLike: isLike,
              post_id: post_id
              
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        })
        .done(function () {
            event.target.innerText = isLike ? event.target.innerText == 'Like' ? 'You Like this Post' : 'Like' :
                event.target.innerText == 'Dislike' ? 'You Dont  Like this Post' : 'Dislike';
            if (isLike) {
                event.target.nextElementSibling.innerText = 'DisLike';
            } else {
                event.target.previousElementSibling.innerText = 'Like';
            }
        })

    })
    
    });
    </script>
@endsection