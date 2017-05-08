@extends('layouts.app')
@section('content')
@includeIf('partials.search_styles')
@includeIf('partials.modal', ['message' => trans('app.confirm_approve_new')])
@includeIf('partials.result')
<div id="message" class="alert alert-success hide"></div>
<div class="panel panel-success">
  <div class="panel-heading">
    <div class="panel-btns">
    <form style="float:right;" method="get" action="" id="search">
      {{ csrf_field() }}
        <input name="search" type="text" size="40" placeholder="Tìm kiếm..." />
      </form>
    </div><!-- panel-btns -->
    <h3 class="panel-title">{{trans('app.list')}}</h3>
  </div>
  <div class="panel-body">
      <!-- <div class="input-group">
         <span class="input-group-addon" style="color: #428bca;">
            <i class="glyphicon glyphicon-search"></i>
         </span>
         <div class="input-group">
            <input id="tableSearch" name="tableSearch" type="text" class="form-control"/>
         </div>
      </div> -->
<div class="table-responsive-vertical shadow-z-1" style="padding-top:1%;">
  <table id="countyTable" class="table table-hover table-mc-light-blue table-bordered table-stripped">
      <thead>
        <tr>
          <th>{{trans('app.id')}}</th>
          <th>{{trans('app.title')}}</th>
          <th>{{trans('app.description')}}</th>
          <th>{{trans('app.status')}}</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
      @if(isset($news) && count($news) > 0)
      	@foreach($news as $new)
		     <tr>
	          <td data-title="ID">{{ $new->id }}</td>
	          <td data-title="Title">{{ $new->title }}</td>
            <td data-title="Subtitle">{{ $new->sub_title }}</td>
	          <td data-title="Status">
	            <span class="label label-{{$new->status_id == 1 ? 'success' : (
                  $new->status_id == 2 ? 'warning' : 'danger'
                )}}">{{ (is_null($new->status()) || is_null($new->status()->first())) ? '' : $new->status()->first()->description }}</span>
	          </td>
	          <td class="table-action-hide" style="font-size:20px;">
                  <a {!! addTooltip('Xem chi tiết') !!} href="{{route('news.show', ['id' => $new->id])}}" style="opacity: 0;"><i class="fa fa-info"></i></a>
                   <a href="javascript:void(0)" {!! addTooltip('Hủy phê duyệt') !!}  onclick="confirmApprove('{{$new->id}}')" class="delete-row" style="opacity: 0;">
                    <i class="fa fa-trash-o"></i>
                   </a>
                    <a {!! addTooltip(trans('app.approve_new')) !!} onclick="confirmOkApprove('{{$new->id}}')" class="approve-new panel-edit">
                      <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                    </a>
                <form name="formDel{{$new->id}}" action="{{route('deleteApproved')}}" method="POST">
                  {{csrf_field()}}
                  <input type="hidden" name="id" value="{{$new->id}}"/> 
                  <input type="hidden" name="reason" value=""/>  
                </form>
	          </td>
	        </tr>
		    @endforeach
      @endif  
      </tbody>
    </table>
  </div>
 {{ $news->render() }}

   </div>
</div>

<!-- Modal -->
<div id="approveModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
     
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-information">Chú ý</i></h4>
      </div>
      <div class="modal-body">
      <form class="form" >
        <div class="form-group describe_news {{ addErrorClass($errors, 'reason') }}">
            <label class="col-sm-4"><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;Lý do từ chối duyệt  {!!isRequired()!!}</label>
            <div class="col-sm-8">
              <textarea class="form-control" rows="5" name="reason" id="comment" value="{{isset($new) ? $new->audio_text : old('reason')}}"></textarea>
              {!! displayFieldError($errors, 'reason') !!}
            </div>
          </div>
        </form>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="cancelApprove()" data-dismiss="modal"><i class="fa fa-thumbs-o-up"></i>&nbsp;{{ isset($btn_custom) ? $btn_custom : trans('app.ok')}}</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;{{trans('app.close')}}</button>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
	// Show aciton upon row hover
    jQuery('#countyTable tbody tr').hover(function(){
      jQuery(this).find('.table-action-hide a').animate({opacity: 1});
    },function(){
      jQuery(this).find('.table-action-hide a').animate({opacity: 0});
    });

    function cancelApprove()
    {
      id = localStorage.getItem('newId');
      $('form[name=formDel'+id+']>input[name=reason]').val($('textarea[name=reason]').val());

      if (id)
        $('form[name=formDel'+id+']').submit();
    }
   
    function doSomething()
    {
      var id = localStorage.getItem('newId');
      if (id)
        sendApprove(id);
    }

    function confirmApprove(id)
    {
      $('#approveModal').modal('show');
      localStorage.setItem('newId', id);
    }

    function confirmOkApprove(id)
    {
      $('#myModal').modal('show');
      localStorage.setItem('newId', id);
    }

     function sendApprove(id)
      {
        $.ajax({
          url : '{{route("approveNew")}}',
          method : 'POST',
          data : {
            newId : id
          }
        }).done(function (res){
          $('#message').removeClass('hide');
          $('#message').addClass('show');
          $('#message').text(res.message ? res.message : '');
            if (res.status == 500)
            {
              $('#message').removeClass('alert-success');
              $('#message').addClass('alert-danger');
            }
            else
            {
              $('#message').removeClass('alert-danger');
              $('#message').addClass('alert-success');
            }
            setTimeout(function(){
              window.location.reload();
            },2500);
        });
      }

</script>

@endsection