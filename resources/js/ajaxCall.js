
// var no=1;
// var outPut = '';
// // var user = " {!! (Auth::user() !!}";
// console.log(user);
// var user = {{!! Auth::user() !!}};

// $(window).scroll(function () {
//     if(no==1)
//     {
//         if ($(window).height() + $(window).scrollTop() == $(document).height()) {
//             no+=5;
//             $.ajax({
//                 type: "POST",
//                 headers: {
//                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                   },
//                 data:{
//                     no: no ,
//                 },
//                 url: "/fetchPost",
//                 cache: false,
//                 success: function(html){
//                     console.log(html);
//                     html.forEach(element => {
//                 //         outPut += `<div class="card-group"> 
//                 //         <div  class="card mt-4 col-md-4 mx-auto"> 
//                 //             <a  class="openModal" data-id="${element.id}"><img  class="card-img-top" src="/storage/post_image/${element.images.path}"> 
//                 //             </a>
//                 //             <div class="interaction">
//                 //                 <a data-id="${element.id}" class="like" href="#">` {{@Auth::user()->likes()->where('post_id' , ${element.id})->first() ? Auth::user()->likes()->where('post_id' , $item->id)->first()->like == 1 ? 'You Like this post' : 'Like' : 'Like'}} ` </a>
        
//                 //                 <a data-id = "${element.id}" class="like" href="#">` {{@Auth::user()->likes()->where('post_id' , ${element.id})->first() ? Auth::user()->likes()->where('post_id' , $item->id)->first()->like == 0 ? 'You dislike  this post' : 'Dislike' : 'Dislike'}} `</a>
//                 //               </div>
//                 //         </div> 
//                 //   </div> `
//                     });
//                     // $('.ajaxFetch').html(outPut);
//                 }
//             });
//         }
//     }
// });