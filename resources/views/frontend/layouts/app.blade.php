<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @toastr_css
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
   
   
</head>
<body class="body-log">
    @yield('style')
    <div id="app"></div>

        @include('frontend.partials._navbar')
        @include('frontend.partials._modal')
        @yield('content')
    
        @include('frontend.partials._footer')
        @include('frontend.partials._script')
        @yield('scripts')
    
    <script src="{{asset('js/select2.min.js')}}"></script>
</body>
</html>
