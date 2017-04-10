<div id="message" class="alert alert-success hide"></div>
<div class="panel panel-info" style="margin : 8%">
  <!-- Default panel contents -->
  <div class="panel-heading">{{ $new ? $new->title : '' }}
  </div>
  <!-- List group -->
  <ul class="list-group">
    <li class="list-group-item">{{ $new ? $new->sub_title : '' }}</li>
    <li class="list-group-item">Created at - {{ $new ? $new->created_at : '' }}</li>
    <li class="list-group-item">Status - 
      <span class="label label-{{$new->status_id == 1 ? 'success' : (
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
