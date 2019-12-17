    let post = 0;

        $('.like').on('click', function (event) {

            const post_id = $(this).data('id');
            let click = $(this);

            const isLike = event.target.previousElementSibling == null;

            if (click.hasClass('fas')) {
                click.addClass('far');
                click.removeClass('fas');
            }else {
                click.addClass('fas');
                click.removeClass('far');
            }

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
        event.preventDefault();
    })
