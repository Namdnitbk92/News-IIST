<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-information"></i>{{ isset($header) ? $header : 'Notifications'}}</h4>
      </div>
      <div class="modal-body">
        <p>{!! $message ?? '' !!}</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="doSomething()" data-dismiss="modal"><i class="fa fa-thumbs-o-up"></i>&nbsp;{{ isset($btn_custom) ? $btn_custom : 'Yes, got it.'}}</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;Close</button>
      </div>
    </div>

  </div>
</div>