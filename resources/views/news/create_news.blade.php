@extends('layouts.app')

@section('content')
<div class="row">
    <div class="panel panel-default">
      <div class="panel-heading" style="background: #1caf9a;">
        <div class="panel-btns">
          <a href="" class="panel-close">&times;</a>
          <a href="" class="minimize">&minus;</a>
        </div>
        <h4 class="panel-title">
          {{ isset($new) ? 'Update this new' : 'Create a new'}}
        </h4>
      </div>
      <div class="panel-body panel-body-nopadding">
      <form class="form" enctype="multipart/form-data" method="POST" novalidate="novalidate" id="newsForm" action="{{ !isset($new) ? route('news.store') : route('news.update', ['id' => $new->id]) }}">
          {{ csrf_field() }}
          @if(isset($new))
              <input type="hidden" name="_method" value="put" />
          @endif
          <input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>
          @include('partials.result')
          
        <!-- BASIC WIZARD -->
        <div id="progressWizard" class="basic-wizard">
          <ul class="nav nav-pills nav-justified">
            <li><a href="#ptab1" data-toggle="tab"><span>Step 1:</span> Basic Info</a></li>
            <li><a href="#ptab2" data-toggle="tab"><span>Step 2:</span> Area Info</a></li>
            <li><a href="#ptab3" data-toggle="tab"><span>Step 3:</span> Audio & Video & Text Info</a></li>
          </ul>
          <div class="tab-content">
            <div class="progress progress-striped active">
              <div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            
            <div class="tab-pane" id="ptab1">
                <div class="form-group {{ addErrorClass($errors, 'title') }}">
                  <label class="col-sm-4">Title</label>
                  <div class="col-sm-8">
                    <input placeholder="The title for this new will be created..." type="text" name="title" class="form-control" value="{{ isset($new) ? $new->title : ''}}"/>
                    {!! displayFieldError($errors, 'title') !!}
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="col-sm-4">Description</label>
                  <div class="col-sm-8">
                    <input placeholder="The description for this new..." type="text" name="sub_title" class="form-control" value="{{isset($new) ? $new->sub_title : ''}}"/>
                  </div>
                </div>

                <div class="form-group {{ addErrorClass($errors, 'publish_time') }}">
                  <label class="col-sm-4">Publish Time</label>
                  <div class="col-sm-8">
                    <div class="input-group">
                       <span class="input-group-addon" style="color: #428bca;">
                          <i class="glyphicon glyphicon-calendar"></i>
                       </span>
                       <div class="input-group">
                          <input id="publishTime" name="publish_time" type="datetime-local" class="form-control"/>
                       </div>
                    </div>
                  {!! displayFieldError($errors, 'publish_time') !!}
                  </div>
                </div>

                
            </div>
            <div class="tab-pane" id="ptab2">

              <form class="form">

              <div class="form-group">
                <label class="col-sm-4">Place</label>
                <div class="col-sm-8">
                  <select class="select2" id="place" name="type">
                    <option value="county">County</option>
                    <option value="city">City</option>
                    <option value="guild">Guild</option>
                  </select>
                </div>
              </div>


                <div class="form-group city_list" style="display:none;">
                  <label class="col-sm-4">City</label>
                  <div class="col-sm-8">
                    {!! renderSelect($cities, 'id', 'name', 'city', 'city' ,'select2') !!}
                  </div>
                </div>
                
                <div class="form-group county_list" style="display:none;">
                  <label class="col-sm-4">County</label>
                  <div class="col-sm-8">
                     {!! renderSelect($counties, 'id', 'name', 'county', 'county' ,'select2') !!}
                  </div>
                </div>
                
                <div class="form-group guild_list" style="display:none;">
                  <label class="col-sm-4">Guild</label>
                  <div class="col-sm-8">
                    {!! renderSelect($guilds, 'id', 'name', 'guild', 'guild' ,'select2') !!}
                  </div>
                </div>
              </form>
            </div>
            <div class="tab-pane" id="ptab3">
               <div class="input-group {{ addErrorClass($errors, 'audio-file') }}">
                  <label class="input-group-btn">
                      <span class="btn btn-primary">
                          <i class="fa fa-upload"></i>&nbsp;Upload audio / video&hellip; <input type="file" name="audio-file" style="display: none;" multiple>
                      </span>
                  </label>
                  <input type="text" class="form-control" readonly>
              </div>
              {!! displayFieldError($errors, 'audio-file') !!}
              <br/>
              <div class="form-group">
                <label for="comment">Text</label> <button style="margin:5px;" class="btn btn-warning"><i class="fa fa-exchange" aria-hidden="true"></i>&nbsp;&nbsp;  Convert to audio/video</button>
                <textarea class="form-control" rows="5" name="audio_text" id="comment"></textarea>
                </br>
              </div>
               
            </div>
          </div><!-- tab-content -->
          
          <ul class="pager wizard">
              <li class="previous"><a href="javascript:void(0)">
              <i class="fa fa-arrow-left"></i>&nbsp;
              Previous</a></li>
              <li class="next"><a href="javascript:void(0)">
              <i class="fa fa-arrow-right"></i>&nbsp;
                Next</a></li>
              @if(isset($new))
              <li class="next" style="float:right;margin-right:5px;">
                <a href="{{route('news.show',['id' => $new->id])}}" class="btn btn-warning" href="javascript:void(0)">
                <i class="fa fa-eye"></i>&nbsp;
                  Detail
                </a>
              </li>
              @endif
              <li class="finish hide" style="float:right;">
                
                <a href="javascript:void(0)">
                  <i class="fa fa-check"></i>&nbsp;Finish
                </a>
              </li>
            </ul>
          </form>
        </div><!-- #basicWizard -->
        
      </div><!-- panel-body -->
    </div><!-- panel -->
    
  </div><!-- row -->
@includeIf('partials.modal', ['message' => 'Are you sure to creat this new?'])
@endsection
@include('scripts.createnews')
