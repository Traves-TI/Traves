<div id='modal' class="modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{__("Alert")}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>{{__("Message")}}</p>
        </div>
        <div class="modal-footer">
          <button type="button" id='cancel' class="btn btn-secondary" hidden data-dismiss="modal">{{__("Cancel")}}</button>
          <button type="button" id='save' class="btn btn-success" data-dismisswithcallback="save">{{__("Save")}}</button>
        </div>
      </div>
    </div>
  </div>
