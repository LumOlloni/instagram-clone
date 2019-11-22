
{{-- Post Modal  --}}
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="text-center modal-title" id="exampleModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <img id="img" class="img-thumbnail ml-5">
          <ul class="text-center mt-3 w-75">
            <div class="container">
              <div class="row tags"></div>
            </div>
          </ul>
          <form class="comment form-inline ml-5">
            <div class="form-group mx-sm-3 mb-2">
                <input type="text" class="form-control" id="bodyComment" placeholder="Enter Comment">
            </div>
            {{-- <ul class="list-group ulList">
            </ul> --}}
            <button type="submit" class="btn btn-primary mb-2">Save</button>
          </form>
            <ul class="list-group ">
              <div class="container">
                <div class="row fetchComment">

                </div>
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


