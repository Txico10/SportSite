<!-- Modal Component -->
<div class="modal fade" id="{{$getModalIdString()}}">
    <div class="modal-dialog {{$type}}">
      <div class="modal-content">
        <div class="modal-header border-bottom-0 bg-lightblue">
        <h4 class="modal-title">
          
            @isset($icon)
              <i class="{{$icon}} mr-2"></i>
            @endisset
          
            {{$title}}
        </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          {{$slot}}
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->