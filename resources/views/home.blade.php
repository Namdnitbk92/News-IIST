@extends('layouts.app')

@section('content')
	<div class="contentpanel">
      <div class="col-sm-12 col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ul class="pull-right">
                    </ul>
                    <h4 class="panel-title">Danh sách nội dung sắp trình chiếu</h4>
                    <p></p>
                </div><!-- panel-heading -->
                <div class="panel-body">
                    
                    <div class="results-list">
                        @if(isset($news) && count($news) > 0)
                        	@foreach($news as $new)
                        	<div class="media">
	                            <a href="{{route('news.show', ['id' => $new->id])}}" class="pull-left">
					                <video  width="400px" controls>
					                    <source src="{{isset($new) ? $new->audio_path.'?autoplay=false' : ''}}">
					                </video>
	                            </a>
	                            <div class="media-body">
	                              <h4 class="filename text-primary">{{$new->title}}</h4>
	                              <small class="text-muted">File Type <b>{{$new->file_type}}</b></small><br>
	                              <small class="text-muted">Status&nbsp;&nbsp;&nbsp;<label class="label label-{{$new->status_id == 1 ? 'success' : (
                $new->status_id == 2 ? 'warning' : 'danger'
              )}}"> {{$new->status->description}}</label></small><br>
	                              <small class="text-muted">Publish at {{$new->publish_time}}</small>
	                            </div>
	                        </div>
                        	@endforeach
                        @endif
                    </div><!-- results-list -->
                </div><!-- panel-body -->
            </div><!-- panel -->
        </div>
    </div>
@endsection
