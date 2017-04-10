@extends('layouts.app')
@includeIf('partials.modal', ['message' => 'Are you sure to approve for this new ?'])
@section('content')
<div id="message" class="alert alert-success hide"></div>
<div class="panel panel-info" style="margin : 8%">
  <!-- Default panel contents -->
  <div class="panel-heading">{{ $new ? $new->title : '' }}
  	<div class="acion-new" style="float:right;font-size:25px;">
		  <a href="{{route('news.edit', ['id' => $new->id])}}"><i class="fa fa-edit"></i></a>&nbsp;
	  	<a data-method="delete" class="jquery-postback" href="{{route('news.destroy', ['id' => $new->id])}}"><i class="fa fa-trash"></i></a>&nbsp;
      <a class="approve-new">
        <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
      </a>&nbsp;
	  </div>
  </div>
  <!-- List group -->
  <ul class="list-group">
    <li class="list-group-item">{{ $new ? $new->sub_title : '' }}</li>
    <li class="list-group-item">Created at - {{ $new ? $new->created_at : '' }}</li>
    <li class="list-group-item">Created by - <b> {{ $user ? $user->name : '' }} </b></li>
    <li class="list-group-item">By Place - <b> {{ $place ? $place->name : '' }} {{ $address ?? '' }} </b></li>
    <li class="list-group-item _status">
      Status - <span class="label label-{{$new->status_id == 1 ? 'success' : (
        $new->status_id == 2 ? 'warning' : 'danger'
      )}}">
      {{ $new && $new->status() ? $new->status()->first()->description ?? '' : '' }}
      </span>
    </li>
    <li class="list-group-item">
    	<div class="embed-responsive embed-responsive-16by9">
		  <iframe class="embed-responsive-item" src="{{$new ? $new->audio_path : ''}}"></iframe>
		</div>	
    </li>
  </ul>
</div>
<script type="text/javascript">
  $(document).on('click', 'a.jquery-postback', function(e) {
      e.preventDefault(); // does not go through with the link.

      var $this = $(this);

      $.post({
          type: $this.data('method'),
          url: $this.attr('href')
      }).done(function (res) {
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
          setTimeout(function () {window.location.href="{{route('news.index')}}"}, 2000);
        }
      });
  });

  $('.approve-new').click(function (){
      $('#myModal').modal('show');
  });


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
          $('li._status').empty();
          $('li._status').append('Status is <span class="label label-warning"> approved</span>');
        } 
      });
    }

</script>
@endsection