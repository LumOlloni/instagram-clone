@include('frontend.partials.ajaxCall')
<div class="ajaxFetch container element">
      @forelse ($post as $item)
          <div class="card-group">
                  <div class="card mt-3 col-md-6 mx-auto">
                      <div style="background-color: #fff;" class="card-header">
                          <div class="row">
                              <div class="col-md-12 mt-4">
                                  <h3>{{$item->description}}</h3>
                              </div>
                          </div>
                      </div>
                      <div class="card-body">
                          <a id="id" class="openModal" data-id="{{$item->id}}"><img  class="card-img-top" src="/storage/post_image/{{$item->images->path}}">
                          </a>
                          <div class="interaction">
{{--                              @if(Auth::user()->likes()->where('post_id' , $item->id)->first())--}}
{{--                                  <a  data-id="{{$item->id}}" class="like" >{!! $dislike !!}</a>--}}
{{--                              @else--}}
{{--                                  <a  data-id="{{$item->id}}" class="like" >{!! $like !!}</a>--}}
{{--                              @endif--}}
                              <a  data-id="{{$item->id}}" class="like" href="#"> {{Auth::user()->likes()->where('post_id' , $item->id)->first() ?
                              Auth::user()->likes()->where('post_id' , $item->id)->first() ? 'Dislike' : 'Like' : 'Like'}}  </a>
                          </div>
                      </div>
                  </div>
            </div>
            @empty
            <h2>No Post Here</h2>
        @endforelse
  </div>


<script src="{{asset('js/like.js')}}"></script>
