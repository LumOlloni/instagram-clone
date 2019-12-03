@extends('frontend.layouts.app')
@section('content')
    <main class="py-4">
        <div class="container">
            <div class="row">
                @foreach($explorer_query as $image)
                        @for($x = 0 ; $x < $image->count() ; $x++)
                            <div class="col-md-4">
                                <figure>
                                    <img class="openModal post_image showImage" data-id="{{$image->id}}" src="/storage/thumbnail/post_thumbnail/{{$image->user->post[$x]->images->path}}"
                                         alt="Image 1">
                                </figure>
                            </div>
                        @endfor
                @endforeach
            </div>
        </div>
    </main>
@endsection
