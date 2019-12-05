<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
  <div class="container">
      <a class="navbar-brand" href="{{ url('/') }}">
         Instagram <i class="fab fa-instagram"></i>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
          <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Left Side Of Navbar -->
          <ul class="navbar-nav mr-auto">

          </ul>

          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ml-auto">
              <!-- Authentication Links -->
              @guest
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                  </li>
                  @if (Route::has('register'))
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                      </li>
                  @endif
              @else
                  <form class="form-inline mr-5">
                      <div class="md-form my-0">
                          <input id="search" name="search" class="form-control mr-sm-2" type="text" placeholder="Search">
                      </div>
                  </form>
                  <div id="result" class="panel panel-default" style="width:250px; position:absolute; top:55px; z-index:1; display:none">
                      <ul  style="margin-top:10px; list-style-type:none;" id="usersList">

                      </ul>
                  </div>
                <li  class="nav-item dropdown">
                    <a id="drop" id="navbarNotification" class="nav-link dropdown-toggle mt-1"  role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  href="#">
                        @if(auth()->user()->unreadNotifications->count())
                            <span id="spanNotification" class="badge badge-danger">{{auth()->user()->unreadNotifications->count()}}</span>
                            <i class="fas fa-bell fa-lg  mr-1"></i>
                            @else
                                <i class="fas fa-bell fa-lg  mr-1"></i>
                        @endif
                    </a>

                    <div   class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarNotification">
{{--            href="{{route('markRead')}}"            --}}
                        @foreach(auth()->user()->unreadNotifications as $n)
                            <a  href="/profile/{{$n->data['action']}}"  id="unreadNotification"  style="background-color: lightgray" class="dropdown-item">
                                {{$n->data['message']}}
                            </a>
                        @endforeach
                        @foreach(auth()->user()->readnotifications  as $n)
                            <a href="/profile/{{$n->data['action']}}"  class="dropdown-item notification">
                                {{$n->data['message']}}
                             </a>
                            @endforeach
                    </div>
                </li>
                <li class="nav-item">
                    <a href="{{route('post.index')}}" class="nav-link">Home</a>
                 </li>
                 <li class="nav-item">
                    <a href="{{url('/createPost')}}" class="nav-link">Post</a>
                 </li>
                  <li class="nav-item">
                      <a href="{{url('/explorer')}}" class="nav-link">Explorer</a>
                  </li>
                 <li class="nav-item">
                    <a class="nav-link" href="/myProfile/{{Auth::id()}}">Profile</a>
                  </li>
                  <li class="nav-item dropdown">
                      <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                          {{ Auth::user()->name }} <span class="caret"></span>
                      </a>

                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                          <a class="dropdown-item" href="{{ route('logout') }}"
                             onclick="event.preventDefault();
                                           document.getElementById('logout-form').submit();">
                              {{ __('Logout') }}
                          </a>

                          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                              @csrf
                          </form>
                      </div>
                  </li>
              @endguest
          </ul>
      </div>
  </div>
</nav>
