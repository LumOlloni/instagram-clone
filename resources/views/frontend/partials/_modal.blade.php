
{{-- Post Modal  --}}
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-hidden="true">
    <div class="modal-dialog" id="modal-width" role="document">
      <div class="modal-content" id="modal-content">
        <div class="modal-header">
            <img id="avatar" style="width: 75px; height: 75px" class="img-thumbnail rounded-circle" alt="">
             <h5 class="text-right ml-4 mt-4 modal-title" id="exampleModalLabel"></h5>
            <a style="display: none;" id="edit_button" class="btn btn-warning mx-auto">Edit Post</a>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span id="closeModal" aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <h4 class="text-center mt-1 titlePost"></h4>
          <img id="img" class="img-thumbnail ml-5">
          <ul class="text-center mt-3 w-75">
            <div class="container">
              <div class="row tags"></div>
            </div>
          </ul>
          <form class=" form-inline ml-5">
            <div class="form-group mx-sm-3 mb-2 ">
                <input  type="text"  id="bodyComment" placeholder="Enter Comment">
            </div>
            {{-- <ul class="list-group ulList">
            </ul> --}}
            <button id="comment"  type="submit" class="comment btn btn-primary mb-3">Save</button>
          </form>
            <ul class="list-group ">
              <div class="container">
                <div class="row fetchComment">

                </div>
                  <div class="ajaxFetchComment"></div>
                  <div class="commentFetch"></div>
              </div>
            </ul>
        </div>
      </div>
    </div>
  </div>
{{-- end of Post Modal --}}




{{-- Comment Modal --}}

<div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="text-center">Comments</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
          <ul class="list-group listItem">

          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- end of Comment Modal --}}



