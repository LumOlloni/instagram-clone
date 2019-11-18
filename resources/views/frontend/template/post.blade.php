@extends('frontend.layouts.app')

@section('content')
<main class="py-4">
  
  <h2 class="text-center">Upload Photo</h2>
  
  <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 mx-auto mt-4">

        <form action="{{route('post.store')}}" method="POST" enctype="multipart/form-data">
            @csrf 
                <div class="form-group">
                    <label for="title">Image Descrption </label>
                    <input value=" {{old('description')}} " placeholder="Enter Title" type="text" class="form-control" name="title" />
                </div>
                <div class="form-group">
                        <label for="message">Image</label>
                        <input type="file" class="form-control" name="img" >
                    </div>
                <div class="form-group">
                    <label for="message">Tags</label>
                    <select class="js-example-basic-multiple form-control" name="tags[]" multiple="multiple">
                        @foreach ($tag as $item)
                            <option value=" {{$item->id}} "> {{$item->name}} </option>
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
</div>
<br><br><br>
</main>
@endsection
@section('scripts')

    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
@endsection