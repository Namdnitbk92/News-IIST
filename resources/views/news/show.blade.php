@extends('layouts.app')

@section('content')
<div class="panel panel-info" style="margin : 8%">
  <!-- Default panel contents -->
  <div class="panel-heading">{{ $new ? $new->title : '' }}
  	<div class="acion-new" style="float:right;font-size:25px;">
		<a href="{{route('news.edit', ['id' => $new->id])}}"><i class="fa fa-edit"></i></a>&nbsp;
	  	<a href="{{route('news.destroy', ['id' => $new->id])}}"><i class="fa fa-trash"></i></a>&nbsp;
	  </div>
  </div>
  <!-- List group -->
  <ul class="list-group">
    <li class="list-group-item">{{ $new ? $new->sub_title : '' }}</li>
    <li class="list-group-item">Created at - {{ $new ? $new->created_at : '' }}</li>
    <li class="list-group-item">Created by - <b> {{ $user ? $user->name : '' }} </b></li>
    <li class="list-group-item">By Place - <b> {{ $place ? $place->name : '' }} {{ $address ?? '' }} </b></li>
    <li class="list-group-item">Status - <span class="label label-success">{{ $new && $new->status() ? $new->status()->first()->description ?? '' : '' }}</span></li>
    <li class="list-group-item">
    	<div class="embed-responsive embed-responsive-16by9">
		  <iframe class="embed-responsive-item" src="{{$new ? $new->audio_path : ''}}"></iframe>
		</div>	
    </li>
  </ul>
</div>
@endsection