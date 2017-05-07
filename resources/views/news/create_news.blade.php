<div class="row " >
    <div class="panel panel-default">
      <div class="">
        <div class="panel-btns">
        </div>
        <h4 class="panel-title" >
          <!-- {{ isset($new) ? trans('app.update_new') : trans('app.create_new')}} -->
        </h4>
      </div>
      <div class="panel-body panel-body-nopadding">
      <div class="form-group" style="padding:2%;">
        <label class="col-sm-4">
          <i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp; {{trans('app.create_new_type')}}
        </label>
        <div class="col-sm-8">
          <select class="select2" id="new_type" name="new_type">
          <option value="none">Hãy chọn kiểu tạo mới nội dung</option>
            <option value="basic">Truyền thống cơ bản</option>
            <option value="quickly">Truyền thống khẩn</option>
          </select>
        </div>
      </div>
      <!-- <div style="border-top: 2px solid #f0ad4e;"></div> -->
      <form class="form" style="padding:2%" enctype="multipart/form-data" method="POST" novalidate="novalidate" id="newsForm" action="{{ !isset($new) ? route('news.store') : route('news.update', ['id' => $new->id]) }}">
          {{ csrf_field() }}
          @if(isset($new))
              <input type="hidden" name="_method" value="put" />
          @endif
          <input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>
          <div class="create_content_additional" style="display:none;">
             <!--section 1-->
            <div class="form-group {{ addErrorClass($errors, 'title') }}">
              <label class="col-sm-4"><i class="fa fa-tag" aria-hidden="true"></i>&nbsp;&nbsp;{{trans('app.title')}} {!!isRequired()!!}</label>
              <div class="col-sm-8">
                <input placeholder="" type="text" name="title" class="form-control" value="{{ isset($new) ? $new->title : old('title')}}" required/>
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
                    <select class="select2 required" id="file_type" name="file_type" >
                      <option value="">Hãy chọn kiểu files</option>
                      <option value="text">Text</option>
                      <option value="audio">Audio</option>
                      <option value="video">Video</option>
                    </select>
                  </div>
                </div>
            <!--end section 2-->

            <!--section 3-->
            <div class="_files" style="display:none;">
              <div class=" files-upload form-group {{ addErrorClass($errors, 'audio_text') }}">
                  <label class="col-sm-4">
                  <i class="fa fa-upload xxx"></i>&nbsp;&nbsp;
                  </label>
                  <div class="col-sm-8">
                      <div class="input-group files-upload" >
                          <label class="input-group-btn">
                              <span class="btn btn-primary">
                                  <i class="fa fa-upload"></i>&nbsp;Chọn file&hellip; <input type="file" name="audio-file" style="display: none;" required>
                              </span>
                          </label>
                          <input type="text" class="form-control" readonly>
                      </div>
                  </div>
              </div>
              <div class="form-group {{ addErrorClass($errors, 'audio_text') }}">
                  <label class="col-sm-4">
                  <i class="fa fa-upload"></i>&nbsp;&nbsp;Files đính kèm
                  </label>
                  <div class="col-sm-8">
                      <br/>
                      <div style="margin-top: -5%;" class="input-group {{ addErrorClass($errors, 'attach-file') }}">
                          <label class="input-group-btn">
                              <span class="btn btn-primary">
                                  <i class="fa fa-upload"></i>&nbsp;&nbsp;Chọn file&hellip; <input type="file" name="attach-file" style="display: none;" multiple>
                              </span>
                          </label>
                          <input type="text" class="form-control" readonly>
                      </div>
                  </div>
              </div>
            </div>
            <br/>
            <div style="display:none;" class="form-group describe_news {{ addErrorClass($errors, 'audio_text') }}">
              <label class="col-sm-4"><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;Nội dung truyền thông  {!!isRequired()!!}</label>
              <div class="col-sm-8">
                <textarea class="form-control" rows="5" name="audio_text" id="comment" value="{{isset($new) ? $new->audio_text : old('audio_text')}}" required></textarea>
                <a href="javascript:void(0)" style="margin:5px;" class="btn btn-warning"><i class="fa fa-exchange" aria-hidden="true"></i>&nbsp;&nbsp;  Convert to audio/video</a>
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
                      <input id="publishTime" name="publish_time" type="datetime-local" class="form-control" value="'2011-09-29'" required/>
                   </div>
                </div>
              </div>
            </div>
            <div style="float:right;margin-right:5px;">  
              <button type="button" action="create" name="btnCreate" class="btn btn-primary"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>&nbsp; <label class="btn-action-new">{{ !isset($new) ? 'Tạo mới nội dung' : 'Sửa nội dung'}}</label></button>

              <button type="reset" data-dismiss="modal" class="left btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i>&nbsp; Hủy</button>
            </div>
            </div>
          </div>
        </form>

       <!--quick create-->

          <div class="create_content_quickly" style="display:none;">
              <form class="form" style="padding:2%;" enctype="multipart/form-data" method="POST" novalidate="novalidate" id="newsFormQuick" action="{{ route('news.store')}}">
                {{ csrf_field() }}
                <input type="hidden" name="quickCreate" value="yes">
                <div class="form-group {{ addErrorClass($errors, 'title') }}">
                    <label class="col-sm-4">Tiêu đề nội dung {!!isRequired()!!}</label>
                    <div class="col-sm-8">
                      <input type="text" name="title" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-group {{ addErrorClass($errors, 'audio_text') }}">
                    <label class="col-sm-4">Nội dung truyền thông {!!isRequired()!!}</label>
                    <div class="col-sm-8">
                      <textarea class="form-control" rows="5" name="audio_text" id="audio_text" required></textarea>
                    </div>
                  </div>
                  <div style="float:right;margin-right:5px;">  
                      <button type="submit" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp; <label class="btn-action-new">{{ !isset($new) ? 'Tạo mới nội dung' : 'Sửa nội dung'}}</label></button>
                      <button type="reset" data-dismiss="modal" class="left btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i>&nbsp; Hủy</button>
                  </div>
              </form>
          </div>
      </div><!-- panel-body -->
    </div><!-- panel -->
    
  </div><!-- row -->
 
@include('scripts.createnews')
