@extends('frontend.layouts.app')

@section('content')
<main class="py-4">
    <h2 class="text-center">Edit Your Post</h2>
    <button data-id="{{$post->id}}"  type="submit" id="btn-del" class="btn btn-danger del-btn">Delete This Post </button>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 mx-auto mt-4">
    
            <form action="{{route('post.update',$post->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                    <div class="form-group">
                        <label for="title">Image Descrption </label>
                        <input value="{{$post->description}}" placeholder="Enter Title" type="text" class="form-control" name="description" />
                    </div>
                    <div class="form-group">
                            <label for="title">Image</label>
                            <img id="img-style"  src="/storage/post_image/{{$post->images->path}}" alt="">
                            <input type="file" class="form-control" name="img" >
                        </div>
                    <div class="form-group">
                        <label for="message">Tags</label>
                        <select class="js-example-basic-multiple form-control" name="tags[]" multiple="multiple">
                            @foreach ($tag as $item)
                                <option value="{{$item->id}}"> {{$item->name}} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">
                              Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @jquery
        @toastr_js
        @toastr_render
    </div>
  </main>
    <br><br>
@endsection
@section('scripts')
    <script>
         @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                toastr.error("{{ $error }}");
             @endforeach
        @endif
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
            $('.js-example-basic-multiple').select2().val({!! json_encode($post->tags()->allRelatedIds()) !!} 
            ).trigger('change');
        });

        const btn_del = document.getElementById('btn-del');

        let id = btn_del.getAttribute('data-id');
        const username = '{!! Auth::user()->username   !!}';

        console.log(username);

        const delButton = (e) => {

            axios.delete(`/post/${id}`)
                .then((response) => {

                    toastr.error("You Delete Succefully this post");
                    window.location.href = `/profile/${username}`;

                    console.log(response);

                }).catch((err) => {
                    console.log(err);
                });
       
            e.preventDefault();
        }

        btn_del.addEventListener('click' , delButton);

    </script>
@endsection