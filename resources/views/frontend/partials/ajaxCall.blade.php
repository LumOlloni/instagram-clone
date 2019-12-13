<script>


    $(document).ready(function () {




        function unReadNotification() {
            let span = document.querySelector('.unRead');
            $.ajax({
                type:'GET',
                url:'/unReadNotification',
                success: function (data) {
                    console.log(data);
                    if (data.length >= 1){
                        for (let i = 0;i < data.length;i++){
                            if (span != null){
                                span.innerText = `${data.length}`;
                            }
                            $('#notification').html(`<a href="/profile/${data[i].action}"
                               id="unreadNotification"  style="background-color: lightgray" class="dropdown-item">${data[i].message}</a>`);
                        }
                    }else if(data.length === 0) {
                        // $('#notification').remove();
                    }
                },
            });
        }

        function readNotification() {
            let notification = null;
            $.ajax({
                type:'GET',
                url:'/readNotification',
                success: function (data) {
                    console.log(data);
                    if (data.length >= 1){
                        for (let i = 0;i < data.length;i++){
                         notification  = $('#readNotifcation').append(`<a href="/profile/${data[i].action}"
                               id="unreadNotification"  style="background-color: white" class="dropdown-item">${data[i].message}</a>`);
                        }
                        return notification;
                    }else if(data.length === 0) {
                        $('#readNotifcation').remove();
                        return  null;
                    }
                },
            });
        }

        $('#drop').off('click').click(function () {

            const span = document.getElementById('spanNotification');
            const unRead = document.getElementById('unreadNotification');

            $.ajax({
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{!! route('markRead')!!}",
                cache: false,
                success: function (data) {
                    if (span) {
                        span.style.display = 'none';
                    }
                    if (unRead) {
                        unRead.style.background = '#fff';
                    }
                    console.log(data);
                }
            })
        });


        $(window).on('load', function() {
            readNotification();
        });
        setInterval(function () {
            unReadNotification();
        },5000);


        $('.openModal').click(function(e) {

            const tags = document.querySelectorAll('.tags');
            const user = '{!! Auth::id() !!}';
            const edit = document.getElementById('editButton');
            const avatar = document.getElementById('avatar');

            var post_id = $(this).data('id');
            createComment(post_id , user);


            $.ajax({
                type: 'GET',
                url: `/post/${post_id}`,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                cache: false,
                success: function (data) {
                    $('.commentFetch').html("");
                    let arr = '';
                    let commnet = '';
                    $('#img').attr('src', `/storage/post_image/${data.images.path}`);

                    if (data.user_id == user) {
                        document.getElementById('edit_button').style.display = "block";
                        document.getElementById('edit_button').href = `/post/${post_id}/edit`;
                    }

                    const user_post = data.user_id;
                    const userName = data.user.username;

                    const image_user = data.user.profile.images.path;
                    avatar.setAttribute('src', `/storage/image_users/${image_user}`);
                    avatar.style.cursor = "pointer";
                    avatar.addEventListener('click', function () {
                        window.location.href = `/profile/${userName}`;
                    });

                    console.log(data);
                    $('.modal-title').html(data.user.name);
                    $('.titlePost').html(data.description);


                    data.tags.forEach(element => {
                        arr += `<div>
                        <p class="ml-2 text-primary col-md-4 ">${element.name}</p>
                    </div>
                    `;
                    });
                    data.comments.forEach(element => {
                        const bool = (element.user_id == user || user_post == user);
                        console.log(bool);

                        let deleteBtn = (bool ? ` <div class="col-md-3">
                                    <button onclick="myFunction(${element.id})" data-delete="${element.id}" id="deleteBtn"  class="mt-1 btn btn-danger deleteBtn ">Delete</button>
                                 </div>` : '');
                        commnet += `<li data-replay="${element.id}"  class="list-group-item col-md-9">
                                ${element.body}
                                <a data-replay="${element.id}"  class="replayedComment" style="float: right;padding-top: 40px; cursor:pointer;color: red;">Replay Comments</a>
                            </li><div class="accordion" data-replay="${element.id}"  id="accordionExample">
                              <div class="col-md-3">
                                <button id="reply" data-toggle="collapse" data-target="#${element.body}" aria-expanded="false" aria-controls="collapseTwo"  class="mt-1 btn btn-primary ">Reply</button>
                              </div>
                                ${deleteBtn}
                              <div id="${element.body}" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                  <div class="input-group mb-3">
                                      <input id="bodyReplay"  type="text" class="form-control replay" placeholder="Replay Comment">
                                      <div class="input-group-append">
                                        <button data-comment="${element.id}" id="replayComment" type="submit" class="input-group-text replay  text-white bg-primary ">Save</button>
                                      </div>
                                    </div>
                              </div>
                          </div>`;

                    });

                    $('.tags').html(arr);

                    $('.fetchComment').html(commnet);

                    replayComment(post_id);
                    fetchReplayComments();


                    $('#exampleModal').modal('show');

                },

            });



            window.myFunction = (id) => {
                $.ajax({
                    type: 'DELETE',
                    url: `/comment/${id}`,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    success: function (data) {

                        $('li').filter(`[data-replay=${id}]`).remove();

                        $('.accordion').filter(`[data-replay=${id}]`).remove();

                        $('#deleteBtn').filter(`[data-delete=${id}]`).remove();

                        $('button').filter(`[data-comment=${id}]`).remove();

                        $('.replay').filter(`[data-comment=${id}]`).remove();

                        console.log(data);

                        toastr.success("Comment Deleted Succefully");

                    },
                    error: function (err) {
                        console.log(err);
                    }
                })
            };

            });

        function  replayComment (post_id) {
            $('.replay').click(function () {
                const comment_id = $(this).data('comment');
                let body = '';
                $("input[type='text']").each(function () {
                    body = body + $(this).val();
                })

                $.ajax({
                    type: "Post",
                    url: "/replayComment",
                    data: {
                        bodyReplay: body,
                        comment_id: comment_id,
                        post_id: post_id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        console.log(data);
                        toastr.success("You replay comment Successfully");
                        body.value = '';
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            });
        }

        function fetchReplayComments(){

            $('.replayedComment').click(function () {

              const  comment_id = $(this).data('replay');

                let output = '';
                $.ajax({
                    type: "GET",
                    url: `/replayedComment/${comment_id}`,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {

                        console.log(response[0].replies);
                        const r = response[0].replies;
                        r.forEach(element => {
                            output += `<li class="list-group-item">${element.body}</li>`;
                        });

                        $('.listItem').html(output);

                    },
                    error: function (err) {
                        console.log(err);
                    }
                });

                $('#commentModal').modal('show');
            })
        }

        function createComment(post_id , user) {
            $('#comment').off('click').click(function (e) {
                const bodyComment = document.getElementById('bodyComment');
                const auth = "{{Auth::id()}}";
                if (bodyComment.value == '') {
                    toastr.error("Empty Body Comment");
                } else {
                    let outPut = '';
                    const insertComment = $.ajax({
                            type: "Post",
                            url: "{{route('comment.store')}}",
                            data: {
                                user_id: auth,
                                post_id: post_id,
                                bodyComment: bodyComment.value
                            },
                            async: true,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (data) {
                                console.log(data);
                                const bool = (data.user_id == user);
                                let text = data.body;
                                let deleteBtn = (bool ? ` <div class="col-md-3">
                                    <button onclick="myFunction(${data.id})" data-delete="${data.id}" id="deleteBtn"  class="mt-1 btn btn-danger deleteBtn ">Delete</button>
                                 </div>` : '');
                               $('.commentFetch').append(`<li data-replay="${data.id}" class=" list-group-item col-md-9">${data.body}
                                          <a data-replay="${data.id}" class="replayedComment" style="float: right;padding-top: 40px; cursor:pointer;color: red;">Replay Comments</a>
                                        </li><div class="accordion" data-replay="${data.id}"  id="accordionExample">
                                      <div class="col-md-3">
                                        <button id="reply" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"  class="mt-1 btn btn-primary ">Reply</button>
                                      </div>
                                        ${deleteBtn}
                                      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                          <div class="input-group mb-3">
                                              <input id="bodyReplay"  type="text" class="form-control replay" placeholder="Replay Comment">
                                              <div class="input-group-append">
                                                <button data-comment="${data.id}" id="replayComment" type="submit" class="input-group-text replay  text-white bg-primary ">Save</button>
                                              </div>
                                            </div>
                                      </div>
                                  </div>`);
                                bodyComment.value = '';
                                replayComment(post_id);
                                fetchReplayComments();
                            },
                            error: function (err) {
                                console.log(err);

                            }
                        }).done(function () {
                            toastr.success("You Commeted Successfully");
                        })
                }
                e.preventDefault();
            });
        }
    });
</script>
