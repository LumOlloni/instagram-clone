@extends('frontend.layouts.app')

@section('style')
    @toastr_css
@endsection

@section('content')

  <main class="py-4">
    <h2 class="text-center">Photo of Users</h2>
     
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

    <script src="{{asset('js/like.js')}}"></script>
    {{-- <script src="{{asset('js/ajaxCall.js')}}"></script> --}}
    <script>
    $(document).ready(function(){
     
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

                  // outPut += `<button data-id="${data.id}" class="btn btn-primary openModal">Open Modal</button> `;
                  $('#load_data').append(data);
             

                  if (data == '') {
                    
                     $('#load_data_message').html("<button type='submit' class='btn btn-warning'>No Data Found </button>");
                     action = 'active';  
                    }
                  else {
                    $('#load_data_message').html("<button type='submit' class='btn btn-warning'>Please Wait ... </button>");
                    action = 'inactive'; 
                  }
                }
            });
      }


      if (action == 'inactive') {
        action = 'active'
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