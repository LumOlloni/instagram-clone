@extends('frontend.layouts.app')
@section('content')
    <main class="py-4">
        <div class="container">
            <div class="row">
                @foreach($explorer_query as $image)
                    @foreach($image->user->post as $i)
                        <div class="col-md-4">
                            <figure>
                                <img class="openModal post_image showImage" data-id="{{$image->id}}"
                                     src="/storage/thumbnail/post_thumbnail/{{$i->images->path}}"
                                     alt="Image 1">
                            </figure>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </main>
@endsection
