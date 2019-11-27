let post = 0;

$('.like').on('click', function (event) {

  const post_id = $(this).data('id');

  const isLike = event.target.previousElementSibling == null;

  $.ajax({
      method: 'POST',
      url: '/likePost',
      data: {
        isLike: isLike,
        post_id: post_id
      },
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
  })
  .done(function () {
      event.target.innerText = isLike ? event.target.innerText == 'Like' ? 'Dislike' : 'Like':'Dislike' ;
  })

    event.preventDefault();

})
