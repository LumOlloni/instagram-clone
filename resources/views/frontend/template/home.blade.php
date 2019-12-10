@extends('frontend.layouts.app')

@section('style')
    @toastr_css
@endsection

@section('content')

  <main class="py-4">
      <h1 class="fasfsa"></h1>
    <h2 class="text-center mt-4">Photo of Users</h2>

    @if (isset($message))
          <div class="text-danger"> {{$message}} </div>
    @endif

      <div class="ajaxFetch container element">
          <div id="load_data" class="load_data"></div>
          <div id="load_data_message"></div>
      </div>

      @jquery
      @toastr_js
      @toastr_render
  </main>
<br><br>
@endsection
@section('scripts')

    <script src="{{asset('js/search.js')}}"></script>

    <script>

    $(document).ready(function(){

        // function unReadNotification() {
        //     let span = document.querySelector('.unRead');
        //     $.ajax({
        //         type:'GET',
        //         url:'/unReadNotification',
        //         success: function (data) {
        //             console.log(data);
        //             if (data.length >= 1){
        //                 for (let i = 0;i < data.length;i++){
        //                     if (span != null){
        //                         span.innerText = `${data.length}`;
        //                     }
        //                     $('#notification').append(`<a href="/profile/${data[i].action}"
        //                        id="unreadNotification"  style="background-color: lightgray" class="dropdown-item">${data[i].message}</a>`);
        //                 }
        //             }else if(data.length === 0) {
        //                 // $('#notification').remove();
        //             }
        //
        //
        //         },
        //     });
        // }
        //
        // function readNotification() {
        //     $.ajax({
        //         type:'GET',
        //         url:'/readNotification',
        //         success: function (data) {
        //             console.log(data);
        //             if (data.length >= 1){
        //                 for (let i = 0;i < data.length;i++){
        //                     $('#readNotifcation').append(`<a href="/profile/${data[i].action}"
        //                        id="unreadNotification"  style="background-color: white" class="dropdown-item">${data[i].message}</a>`);
        //                 }
        //                 }else if(data.length === 0) {
        //                     $('#readNotifcation').remove();
        //                 }
        //         },
        //     });
        // }
        //
        // $(window).on('load', function() {
        //
        //     readNotification();
        //
        // });
        // setInterval(function () {
        //     unReadNotification();
        // },5000);

        var limit = 5;
        var start = 0;
        var action = 'inactive';

      function load_data(limit ,  start){

        $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                data:{
                    limit:limit ,
                    start:start
                },
                url: "/fetchPost",
                cache: false,

                success: function(data){
                  let outPut = '';

                  console.log(data);

                  $('#load_data').append(data);

                  if (data == '') {

                     $('#load_data_message').html("<button type='submit' class='btn btn-warning'>No Data Found </button>");
                     action = 'active';

                    }
                  // else {
                  //   $('#load_data_message').html("<button type='submit' class='btn btn-warning'>Please Wait ... </button>");
                  //   action = 'inactive';
                  // }
                }
            });
      }

      if (action == 'inactive') {
        action = 'active';
        load_data(limit ,  start);

      }

      $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height() > $('#load_data').height() && action == 'inactive') {

          action = 'active';
          start = start + limit;

          setTimeout(function () {
            load_data(limit ,  start);
          },1000);
        }
        });
    });

    </script>
@endsection
