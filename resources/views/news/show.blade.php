@extends('layouts.app')
@includeIf('partials.modal', ['message' => 'Are you sure to approve for this new ?'])
@section('content')
<div id="message" class="alert alert-success hide"></div>

<div class="row">
  @include('partials.result')
  <form id="copyNew" method="POST" action="{{ route('copyNew', ['id' => $new->id]) }}">
    {{csrf_field()}}
  </form>
  <form id="noticeApprove" method="POST" action="{{ route('noticeApprove', ['id' => $new->id]) }}">
    {{csrf_field()}}
  </form>
  <form id="deleteNew" method="POST" action="{{ route('news.destroy', ['id' => $new->id]) }}">
    {{csrf_field()}}
    {{ method_field('DELETE') }}
  </form>
  <div class="panel panel-default panel-alt widget-messaging">
    <div class="panel-heading">
        <div class="panel-btns">
          <a class="panel-edit" href="{{route('news.edit', ['id' => $new->id])}}"><i class="fa fa-edit "></i></a>&nbsp;
          <a class="panel-edit" href="javascript:void(0);" onclick="copy();"><i class="fa fa-files-o" aria-hidden="true"></i></a>&nbsp;
          <a class="panel-edit" href="javascript:void(0);" onclick="noticeApprove();"><i class="fa fa-share" aria-hidden="true"></i></a>&nbsp;

          <a class="panel-edit" href="javascript:void(0);" onclick="deleteNew();"><i class="fa fa-trash-o" aria-hidden="true"></i></a>&nbsp;
          <a class="approve-new panel-edit">
            <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
          </a>
        </div><!-- panel-btns -->
        <h3 class="panel-title">{{ isset($new) ? $new->sub_title : '' }}</h3>
      </div>
      <div class="panel-body">
        <ul>
          <li>
            <h5 class="pull-right">{{ isset($new) ? $new->created_at : '' }}</h5>
            <h4 class="sender"><i class="fa fa-calendar" aria-hidden="true"></i> Created at </h4>
          </li>
          <li>
            <h5 class="pull-right">{{ isset($user) ? $user->name : '' }}</h5>
            <h4 class="sender"><i class="fa fa-calendar" aria-hidden="true"></i> Created by <b> </h4>
          </li>
          <li>
            <h5 class="pull-right">{{ isset($place) ? $place->name : '' }} {{ $address ?? '' }}</h5>
            <h4 class="sender"> <i class="fa fa-building-o" aria-hidden="true"></i> By Place <b> </h4>
          </li>
          <li><i class="fa fa-hand-o-right" aria-hidden="true"></i>  
            Status 
            <h5 class="pull-right _status">
              <span class="label label-{{$new->status_id == 1 ? 'success' : (
                $new->status_id == 2 ? 'warning' : 'danger'
              )}}">
              {{ isset($new) && $new->status() ? $new->status()->first()->description ?? '' : '' }}
            </span>

            </h5>
          </li>
          <li>
            <h5 class="pull-right">{{ isset($new) ? $new->publish_time : '' }}</h5>
            <h4 class="sender"><i class="fa fa-calendar"></i>&nbsp;Publish Time</h4>
          </li>
          <li>
              <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="{{isset($new) ? $new->audio_path : ''}}"></iframe>
              </div>  
          </li>
          <li>
            <h3>Text</h3>
            <h4>{{ isset($new) ? $new->audio_text : '' }}</h4>
          </li>
        </ul>
      </div><!-- panel-body -->
    </div>
</div>
<script type="text/javascript">
  $('.approve-new').click(function (){
      $('#myModal').modal('show');
  });

  function copy()
  {
    $('form[id=copyNew]').submit();
  }

  function noticeApprove()
  {
    $('form[id=noticeApprove]').submit();
  }

  function deleteNew()
  {
    $('form[id=deleteNew]').submit();
  }

  function noticeApprove()
  {
    $('form[id=noticeApprove]').submit();
  }


  function doSomething()
  {
    $.ajax({
      url : '{{route("approveNew")}}',
      method : 'POST',
      data : {
        newId : '{{$new->id}}'
      }
    }).done(function (res){
      $('#message').removeClass('hide');
      $('#message').addClass('show');
      $('#message').text(res.message);
      if (res.status == 500)
      {
        $('#message').removeClass('alert-success');
        $('#message').addClass('alert-danger');
      }
      else
      {
        $('li ._status').empty();
        $('li ._status').append('<span class="label label-warning">' + res.status_text +'</span>');
      } 
    });
  }

</script>
@endsection