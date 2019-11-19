@extends('frontend.layouts.app')

@section('style')
    @toastr_css
@endsection

@section('content')
{{-- data-toggle="modal" data-target="#exampleModal" --}}
  <main class="py-4">
    <h2 class="text-center">Photo of Users</h2>
      <div class="container element"> 
          @forelse ($post as $item)
          <div class="card-group"> 
                <div class="card col-md-4 mx-auto"> 
                    <a  class="openModal" data-id="{{$item->id}}"><img  class="card-img-top" src="/storage/post_image/{{$item->images->path}}"> 
                    </a>
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
                commnet += `<li class=" list-group-item col-md-9">${element.body}</li>
                <div class="accordion" id="accordionExample">
                  <div class="col-md-3">
                    <button data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"  class="mt-1 btn btn-primary">Reply</button>
                  </div>
                  <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                      <div class="input-group mb-3">
                          <input type="text" class="form-control" placeholder="Replay Comment" aria-describedby="basic-addon2">
                          <div class="input-group-append">
                            <input type="submit" value="Save" class="input-group-text text-white bg-primary" />
                          </div>
                        </div>
                  </div>
              </div>
              `  
              });
              $('.tags').html(arr);
              $('.fetchComment').html(commnet);
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
            // outPut += `<li class="list-group-item">${data.body}</li>`;
            // $('.fetchComment').html(outPut);
          },
          error:function(err){
            console.log(err);
          }
        });
      }
        e.preventDefault();
      });

      

      });
    
    });
    </script>
@endsection