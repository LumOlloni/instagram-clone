<script>

    $(document).ready(function () {

        $('#drop').click(function () {
            // alert('request');
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
                            $('#notification').append(`<a href="/profile/${data[i].action}"
                               id="unreadNotification"  style="background-color: lightgray" class="dropdown-item">${data[i].message}</a>`);
                        }
                    }else if(data.length === 0) {
                        // $('#notification').remove();
                    }


                },
            });
        }

        function readNotification() {
            $.ajax({
                type:'GET',
                url:'/readNotification',
                success: function (data) {
                    console.log(data);
                    if (data.length >= 1){
                        for (let i = 0;i < data.length;i++){
                            $('#readNotifcation').append(`<a href="/profile/${data[i].action}"
                               id="unreadNotification"  style="background-color: white" class="dropdown-item">${data[i].message}</a>`);
                        }
                    }else if(data.length === 0) {
                        $('#readNotifcation').remove();
                    }
                },
            });
        }

        $(window).on('load', function() {

            readNotification();

        });
        setInterval(function () {
            unReadNotification();
        },5000);

        $('.openModal').click(function(e){

            const tags = document.querySelectorAll('.tags');
            const user = '{!! Auth::id() !!}';
            const edit = document.getElementById('editButton');
            const avatar = document.getElementById('avatar');
            // const title = document.querySelector('.titlePost');

            var post_id = $(this).data('id');

            $.ajax({
                type:'GET',
                url: `/post/${post_id}`,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                success:function(data){
                    let arr = '';
                    let commnet = '';

                    $('#img').attr('src' , `/storage/post_image/${data.images.path}`);

                    if (data.user_id ==  user) {
                        document.getElementById('edit_button').style.display = "block";
                        document.getElementById('edit_button').href = `/post/${post_id}/edit`;

                    }
                    const user_post = data.user_id;
                    const userName = data.user.username;

                    const image_user = data.user.profile.images.path;
                    avatar.setAttribute('src' , `/storage/image_users/${image_user}`);
                    avatar.style.cursor = "pointer";
                    avatar.addEventListener('click' , function () {
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

                        const bool = (element.user_id == user || user_post == user );
                        console.log(bool);

                        let deleteBtn = (bool ? ` <div class="col-md-3">
                                    <button onclick="myFunction(${element.id})" data-delete = "" id="deleteBtn"  class="mt-1 btn btn-danger deleteBtn ">Delete</button>
                                 </div>` : '');

                        commnet += `<li data-replay="${element.id}"  class="replayedComment list-group-item col-md-9">${element.body}</li><div class="accordion" id="accordionExample">
                              <div class="col-md-3">
                                <button id="reply" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"  class="mt-1 btn btn-primary ">Reply</button>
                              </div>
                                ${deleteBtn}
                              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
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

                    $('.replay').click(function () {
                        const comment_id = $(this).data('comment');
                        let body = '';
                        $("input[type='text']").each(function() {
                            body = body + $(this).val();
                        })

                        $.ajax({

                            type:"Post",
                            url:"/replayComment",
                            data:{
                                bodyReplay:body,
                                comment_id:comment_id,
                                post_id:post_id
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success:function(data){
                                console.log(data);
                                toastr.success("You replay comment Successfully");
                                body.value = '';
                            },
                            error:function(err){
                                console.log(err);
                            }
                        });
                    });

                    $('.replayedComment').click(function(){

                        const comment_id = $(this).data('replay');

                        let output = '';
                        $.ajax({
                            type:"GET",
                            url:`/replayedComment/${comment_id}`,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success:function(response){

                                console.log(response[0].replies);
                                const r = response[0].replies;
                                r.forEach(element => {
                                    output += `<li class="list-group-item">${element.body}</li>`;
                                });

                                $('.listItem').html(output);

                            },
                            error:function(err){
                                console.log(err);
                            }
                        });

                        $('#commentModal').modal('show');
                    })

                    $('#exampleModal').modal('show');
                }
            })

            $('.comment').click(function (e) {
                const bodyComment = document.getElementById('bodyComment');
                const auth = "{{Auth::id()}}";

                if (bodyComment.value == '') {
                    toastr.error("Empty Body Comment");
                }
                else {
                    let outPut = '';
                    $.ajax({
                        type:"Post",
                        url:"{{route('comment.store')}}",
                        data:{
                            user_id:auth,
                            post_id:post_id,
                            bodyComment:bodyComment.value
                        },
                        cache: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success:function(data){

                            toastr.success("Comment created Successfully");
                            console.log(data);
                            const bool = (data.user_id == user);
                            let text = data.body;
                            let accordian = document.createElement('div');
                            accordian.className = 'accordion';
                            accordian.style.display = 'inline';
                            accordian.id = 'accordionExample';
                            const li_item = document.createElement('li');

                            li_item.className = 'replayedComment list-group-item col-md-9';
                            // li_item.textContent = `${data.body}`;
                            li_item.setAttribute('data-replay' , `${data.id}`);

                            let deleteBtn = (bool ? ` <div class="col-md-3">
                                <button onclick="myFunction(${data.id})" id="deleteBtn"  data-delete = "${data.id}"  class="mt-1 btn btn-danger deleteBtn">Delete</button>
                             </div>` : '');

                            accordian.innerHTML = `
                                  <div style="float: right"  class="col-md-3 parentElement">
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
                              `;

                            li_item.appendChild(document.createTextNode(`${data.body}`));
                            document.querySelector('.ajaxFetchComment').appendChild(li_item).after(accordian);
                            // $('.ajaxFetchComment').html(accordian);

                            bodyComment.value = '';
                            //    ;
                        },
                        error:function(err){
                            console.log(err);
                        }
                    });
                }
                e.preventDefault();
            });

            window.myFunction = (id) => {

                $.ajax({
                    type:'DELETE',
                    url:`/comment/${id}`,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function (data) {
                        $('li').filter(`[data-replay=${data.id}]`).remove();
                        $('.parentElement').remove();


                        $('button').filter(`[data-comment=${data.id}]`).remove();

                        $('.replay').filter(`[data-comment=${data.id}]`);

                        $('#reply').remove();
                        $('#replayComment').remove();
                        $('#deleteBtn').remove();
                        console.log(data);
                        toastr.success("Comment Deleted Succefully");
                    },
                    error:function (err) {
                        console.log(err);
                    }
                })
            };
        });


    });

</script>
