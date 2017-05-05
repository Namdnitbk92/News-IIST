@extends('layouts.app')
@section('content')
<div class="row " >
    <div class="panel panel-default">
      <div class="panel-heading" style="background: #1caf9a;">
        <div class="panel-btns">
        </div>
        <h4 class="panel-title" style="color:white;">
          {{ isset($new) ? trans('app.update_new') : trans('app.create_new')}}
        </h4>
      </div>
      <div class="panel-body panel-body-nopadding">
      <form class="form" style="padding:5%" enctype="multipart/form-data" method="POST" novalidate="novalidate" id="newsForm" action="{{ !isset($new) ? route('news.store') : route('news.update', ['id' => $new->id]) }}">
          {{ csrf_field() }}
          @if(isset($new))
              <input type="hidden" name="_method" value="put" />
          @endif
          <input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>
          @include('partials.result')
          <div class="create_content_additional">
             <!--section 1-->
            <div class="form-group {{ addErrorClass($errors, 'title') }}">
              <label class="col-sm-4"><i class="fa fa-tag" aria-hidden="true"></i>&nbsp;&nbsp;{{trans('app.title')}} {!!isRequired()!!}</label>
              <div class="col-sm-8">
                <input placeholder="" type="text" name="title" class="form-control" value="{{ isset($new) ? $new->title : old('title')}}"/>
                {!! displayFieldError($errors, 'title') !!}
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-4"><i class="fa fa-file-text-o" aria-hidden="true"></i>&nbsp;&nbsp;{{trans('app.description')}}</label>
              <div class="col-sm-8">
                <input placeholder="" type="text" name="sub_title" class="form-control" value="{{isset($new) ? $new->sub_title : old('sub_title')}}"/>
              </div>
            </div>

            

            <!--section 2-->
              <!-- <div class="form-group">
                <label class="col-sm-4"><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;{{trans('app.place')}} {!!isRequired()!!}</label>
                <div class="col-sm-8">
                  <select class="select2" id="place" name="type">
                    <option value="county">{{trans('app.county')}}</option>
                    <option value="city">{{trans('app.city')}}</option>
                    <option value="guild">{{trans('app.guild')}}</option>
                  </select>
                </div>
              </div> -->


                <div class="form-group city_list" style="display:none;">
                  <label class="col-sm-4"><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;&nbsp; {{trans('app.communication_range')}}</label>
                  <div class="col-sm-8">
                    {!! renderSelect($cities, 'id', 'name', 'city', 'city' ,'select2') !!}
                  </div>
                </div>
                
                <div class="form-group county_list" style="display:none;">
                  <label class="col-sm-4"><i class="fa fa-file-text" aria-hidden="true"></i>    {{trans('app.communication_range')}}</label>
                  <div class="col-sm-8">
                     {!! renderSelect($counties, 'id', 'name', 'county', 'county' ,'select2') !!}
                  </div>
                </div>
                
                <div class="form-group guild_list" style="display:none;">
                  <label class="col-sm-4"><i class="fa fa-envelope" aria-hidden="true"></i>{{trans('app.communication_range')}}</label>
                  <div class="col-sm-8">
                    {!! renderSelect($guilds, 'id', 'name', 'guild', 'guild' ,'select2') !!}
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-4"><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;{{trans('app.file_type')}} {!!isRequired()!!}</label>
                  <div class="col-sm-8 {{ addErrorClass($errors, 'audio-file') }}">
                    <select class="select2" id="file_type" name="file_type">
                    <option value="none">Hãy chọn kiểu files</option>
                      <option value="text">Text</option>
                      <option value="audio">Audio</option>
                      <option value="video">Video</option>
                    </select>
                    {!! displayFieldError($errors, 'audio-file') !!}
                  </div>
                </div>
            <!--end section 2-->

            <!--section 3-->
            <div class="_files" style="display:none;">
              <div class="form-group {{ addErrorClass($errors, 'audio_text') }}">
                  <label class="col-sm-4">
                  </label>
                  <div class="col-sm-8">
                      <div class="input-group files-upload">
                          <label class="input-group-btn">
                              <span class="btn btn-primary">
                                  <i class="fa fa-upload file-name"></i>&nbsp;&hellip; <input type="file" name="audio-file" style="display: none;" multiple>
                              </span>
                          </label>
                          <input type="text" class="form-control" readonly>
                      </div>
                      
                      <br/>
                      <div class="input-group {{ addErrorClass($errors, 'attach-file') }}">
                          <label class="input-group-btn">
                              <span class="btn btn-primary">
                                  <i class="fa fa-upload"></i>&nbsp;&nbsp;Files đính kèm&hellip; <input type="file" name="attach-file" style="display: none;" multiple>
                              </span>
                          </label>
                          <input type="text" class="form-control" readonly>
                      </div>
                      {!! displayFieldError($errors, 'attach-file') !!}
                  </div>
              </div>
            </div>
            <br/>
            <div class="form-group {{ addErrorClass($errors, 'audio_text') }}">
              <label class="col-sm-4"><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;Nội dung truyền thông  {!!isRequired()!!}</label>
              <div class="col-sm-8">
                <textarea class="form-control" rows="5" name="audio_text" id="comment" value="{{isset($new) ? $new->audio_text : old('audio_text')}}"></textarea>
                <a href="javascript:void(0)" style="margin:5px;" class="btn btn-warning"><i class="fa fa-exchange" aria-hidden="true"></i>&nbsp;&nbsp;  Convert to audio/video</a>
                {!! displayFieldError($errors, 'audio_text') !!}
              </div>
              
            </div>
            <div class="form-group {{ addErrorClass($errors, 'publish_time') }}">
              <label class="col-sm-4"><i class="fa fa-calendar"></i>&nbsp;&nbsp;{{trans('app.publish_time')}} {!!isRequired()!!}</label>
              <div class="col-sm-8">
                <div class="input-group">
                   <span class="input-group-addon" style="color: #428bca;">
                      <i class="glyphicon glyphicon-calendar"></i>
                   </span>
                   <div class="input-group">
                      <input id="publishTime" name="publish_time" type="datetime-local" class="form-control" value="{{old('publish_time')}}"/>
                   </div>
                </div>
              {!! displayFieldError($errors, 'publish_time') !!}
              </div>
            </div>

            <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i>&nbsp; {{ !isset($new) ? 'Tạo mới nội dung' : 'Sửa nội dung'}}</button>
            <a class="panel-edit btn btn-warning" onclick="goBack()"><i class="fa fa-arrow-left"></i></a>&nbsp;</a>
            </div>
          </div>
        </form>

      </div><!-- panel-body -->
    </div><!-- panel -->
<script>
function goBack() {
    window.history.back();
}
</script>
  </div><!-- row -->
@endsection
@include('scripts.createnews')