<script>

    $(document).ready(function () {

        $('.openModal').click(function(e){

            const tags = document.querySelectorAll('.tags');
            const user = '{!! Auth::id() !!}';
            const edit = document.getElementById('editButton');

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

                    console.log(data);
                    $('.modal-title').html(data.description);
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
                    // console.log("Error ");
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
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success:function(data){

                            toastr.success("Comment created Successfully");
                            console.log(data);

                            // const bool = (data.user_id == user);
                            //
                            // let deleteBtn = (bool ? ` <div class="col-md-3">
                            //     <button onclick="myFunction(${data.id})" id="deleteBtn"  data-delete = "${data.id}"  class="mt-1 btn btn-danger deleteBtn">Delete</button>
                            //  </div>` : '');
                            //
                            //
                            //
                            //
                            // outPut += `<li data-replay="${data.id}"  class="replayedComment list-group-item col-md-9">${data.body}</li><div class="accordion" id="accordionExample">
                            //       <div class="col-md-3 parentElement">
                            //         <button id="reply" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"  class="mt-1 btn btn-primary ">Reply</button>
                            //       </div>
                            //         ${deleteBtn}
                            //       <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                            //           <div class="input-group mb-3">
                            //               <input id="bodyReplay"  type="text" class="form-control replay" placeholder="Replay Comment">
                            //               <div class="input-group-append">
                            //                 <button data-comment="${data.id}" id="replayComment" type="submit" class="input-group-text replay  text-white bg-primary ">Save</button>
                            //               </div>
                            //             </div>
                            //       </div>
                            //   </div>`;


                            $('.ajaxFetchComment').html(outPut);
                            bodyComment.value = '';
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
