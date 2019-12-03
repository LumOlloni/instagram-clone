@include('frontend.partials.ajaxCall')
<div class="ajaxFetch container element">
      @forelse ($post as $item)

          <div class="card-group">
                  <div  class="card mt-4 col-md-4 mx-auto">

                      <a id="id" class="openModal" data-id="{{$item->id}}"><img  class="card-img-top" src="/storage/post_image/{{$item->images->path}}">
                      </a>
                      <div class="interaction">
                          <a  data-id="{{$item->id}}" class="like" href="#"> {{Auth::user()->likes()->where('post_id' , $item->id)->first() ? Auth::user()->likes()->where('post_id' , $item->id)->first() ? 'Dislike' : 'Like' : 'Like'}} </a>
                        </div>
                  </div>
            </div>
            @empty
            <h2>No Post Here</h2>

        @endforelse
  </div>


<script src="{{asset('js/like.js')}}"></script>
