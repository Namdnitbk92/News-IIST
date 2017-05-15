@extends('layouts.app')
@section('content')
@includeIf('partials.result')
@includeIf('partials.modal', ['message' => trans('app.confirm_approve_new') ])
<div id="message" class="alert alert-success hide"></div>
<div class="panel panel-success">
  <div class="panel-heading">
    <div class="panel-btns">
    @if (!isset($listAvaiableApprove))
      <form style="float:right;" method="get" action="{{route('search_news')}}" id="search">
      {{ csrf_field() }}
        <input name="search" type="text" size="40" placeholder="Tìm kiếm..." />
      </form>
    @endif
      <!-- <form style="float:right;" action="{{route('search_news')}}" method="GET" name="searchForm">
        {{ csrf_field() }}
        <input type="search" id="search" name="search"  placeholder="">
      </form> -->
    </div><!-- panel-btns -->
    <h3 class="panel-title">{{trans('app.list')}}</h3>
  </div>
  <div class="panel-body">
     <!-- <div class="input-group">
         <span class="input-group-addon trigger_search" style="color: #428bca;">
            <i class="glyphicon glyphicon-search"></i>
         </span>
         <div class="input-group">
            <form action="{{route('search_news')}}" method="GET" name="searchForm">
              {{ csrf_field() }}
              <input type="search" id="search" name="search" class="form-control" placeholder="" aria-controls="table2">
            </form>
         </div>
      </div> -->
      <div class="input-group" style="float:right;padding:5px;">
         @if(Auth::user()->isCreater() && $titlePage === trans('app.news_list'))
          <a class="btn btn-primary-alt" href="javascript:void(0)" onclick="quickNews()"><i class="fa fa-plus"></i>&nbsp;&nbsp;{{trans('app.create_new')}}</a>
        @endif 
      </div>
      <div class="table-responsive-vertical shadow-z-1" style="padding-top:1%;">
      <table id="table" class="table table-hover table-mc-light-blue table-bordered table-stripped">
          <thead>
            <tr>
              <th>{{trans('app.id')}}</th>
              <th>{{trans('app.title')}}</th>
              <th>{{trans('app.description')}}</th>
              <th>{{trans('app.file_type')}}</th>
              <th>{{trans('app.status')}}</th>
              <th style="width:20%;">Lý do từ chối</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
          @if(isset($news) && count($news) > 0)
          	@foreach($news as $new)
    			     <!-- <tr onclick="redirect('{{$new->id}}')"> -->
               <tr>
    	          <td data-title="ID">{{ $new->id }}</td>
    	          <td data-title="Title">{{ $new->title }}</td>
    	          <td data-title="SubTitle">
    	            {{ $new->sub_title }}
    	          </td>
                <td data-title="File_Type">
                  {{ $new->file_type }}
                </td>
    	          <td data-title="Status">
                  <?php $statusText = (is_null($new->status()) || is_null($new->status()->first())) ? '' : $new->status()->first()->description;?>
                  @if($new->status_id == 1)
                    <span class="label label-success">
                        {{$statusText}}
                    </span>
                  @elseif($new->status_id == 2)
                    <span class="label label-warning">
                        {{$statusText}}
                    </span>
                  @elseif($new->status_id == 3)
                    <span class="label label-primary">
                        {{$statusText}}
                    </span>
                  @else
                    <span class="label label-danger">
                        {{$statusText}}
                    </span>
                  @endif
    	          </td>
                <td style="width:20%;">{{$new->reason ?? ''}}</td>
                <td style="font-size:20px;width:20%;">
                  <form id="copyNew{{$new->id}}" method="POST" action="{{ route('copyNew', ['id' => $new->id]) }}">
                    {{csrf_field()}}
                  </form>
                  <form id="noticeApprove{{$new->id}}" method="POST" action="{{ route('noticeApprove', ['id' => $new->id]) }}">
                    {{csrf_field()}}
                  </form>
                  <form id="deleteNew{{$new->id}}" method="POST" action="{{ route('news.destroy', ['id' => $new->id]) }}">
                    {{csrf_field()}}
                    {{ method_field('DELETE') }}
                  </form>
                  <a {!! addTooltip('Xem trước nội dung') !!} onclick="preview('{{$new->id}}')" class="panel-edit" href="javascript:void(0)"><i class="fa fa-eye "></i></a>&nbsp;
                @if(Auth::user()->isCreater())
                    @if($titlePage === trans('app.news_list'))
                      @if($new->status_id === '1')
                      <a {!! addTooltip(trans('app.update_new')) !!} class="panel-edit" href="javascript:void(0)" onclick="quickNews('{{$new->id}}')"><i class="fa fa-edit"></i></a>&nbsp;
                      @endif
                      <a {!! addTooltip(trans('app.copy_new')) !!} class="panel-edit" href="javascript:void(0);" onclick="quickNews('{{$new->id}}', 'copy');"><i class="fa fa-files-o" aria-hidden="true"></i></a>&nbsp;
                      @if($new->status_id != 2)
                      <a  {!! addTooltip(trans('app.delete_new')) !!} class="panel-edit" href="javascript:void(0);" onclick="deleteNew('{{$new->id}}');"><i style="color: red;" class="fa fa-trash-o" aria-hidden="true"></i></a>&nbsp;
                      @endif
                      @endif
                      @if(Auth::user()->isApprover())
                      <a {!! addTooltip(trans('app.approve_new')) !!} class="approve-new panel-edit">
                        <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                      </a>
                    @endif  
                    @if($new->status_id === '1')
                    <a {!! addTooltip(trans('app.makes_required_approve')) !!} class="panel-edit" href="javascript:void(0);" onclick="noticeApprove('{{$new->id}}');"><i class="fa fa-share" aria-hidden="true"></i></a>&nbsp;
                    @endif
                  @endif
                </td>
    	        </tr>
    		    @endforeach
          @endif  
          </tbody>
        </table>
      </div>
      {{ $news->render() }} 
      @if(isset($news) && count($news) >= 0)
          <!-- <div class="row" style="position: inherit;bottom:10%;">
            <label class="label label-success pull-right">
            {{$quantity ?? 0}} / {{ $total ?? 0 }} Records.</label>
          </div> -->
      @endif
   </div>
</div>
</div>

<!-- Modal -->
<div id="newModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="background: #f0ad4e;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-information"></i>Tạo mới nội dung</h4>
      </div>
      <div class="modal-body">
        <?php unset($new)?>
        @includeIf('news.create_news')
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="doSomething()" data-dismiss="modal"><i class="fa fa-thumbs-o-up"></i>&nbsp;{{ isset($btn_custom) ? $btn_custom : trans('app.ok')}}</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;{{trans('app.close')}}</button>
      </div> -->
    </div>

  </div>
</div>


<!-- Preview Modal -->
<div id="previewModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="background: #f0ad4e;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-information"></i>Xem trước nội dung</h4>
      </div>
      <div class="modal-body">
        @if(\App\News::count() > 0)
          @includeIf('news.show', ['new' => \App\News::find(1)])
        @endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;Thoát</button>
      </div>
    </div>

  </div>
</div>

<script>
	function redirect(id)
	{
		window.location.href = "/news/" + id;
	}

  function fillDataForm(id, action)
  {
    localStorage.setItem('newIdUpdate', id);
    $.ajax({
      url : "{{route('getNewDetail')}}",
      type : 'POST',
      data : {'newId' : id}
    }).done(function (res){
      if (res.errorCode !== 0)
        return;

      res = JSON.parse(res.new);
      $('.modal-title').text('Sửa nội dung');
      $('.btn-action-new').text('Sửa nội dung');
      $('input[name=title]').val(res.title);
      $('input[name=sub_title]').val(res.sub_title ? res.sub_title : '');
      $('textarea[name=audio_text]').val(res.audio_text ? res.audio_text : '');
      $('select[name=file_type]').val(res.file_type ? res.file_type : '');
      $('select[name=file_type]').select2('val', (res.file_type ? res.file_type : 'text'));
      $('#file_type').trigger('change');
      var date = res.publish_time ? new Date(res.publish_time) : new Date();
      var tzoffset = date.getTimezoneOffset() * 60000; 
      var localISOTime = (new Date(date.getTime() - tzoffset)).toISOString().slice(0,-1);
      document.getElementById("publishTime").defaultValue = localISOTime;
      var btn = $('button[name=btnCreate]');
      if (action === 'copy')
      {
        $('.modal-title').text('Sao chép nội dung');
        $('.btn-action-new').text('Sao chép nội dung');
        btn.attr('action', 'create');
        $('#newsForm').append('<input type="hidden" name="newId" value="'+ id +'"/>');
        $('#newsForm').append('<input type="hidden" name="action" value="copy"/>');
      }
      else
      {
        btn.attr('action', 'update');
      }
    })
  }

  // $('#newsForm').on('submit', function(e){
  //     e.preventDefault();
  // })

  $('button[name=btnCreate]').click(function (){
    var action = $('button[name=btnCreate]').attr('action');
    if (action === 'create')
    {
      $('#newsForm').attr('action', '{{route("news.store")}}');
    }
    else 
    {
      $('#newsForm').append('<input type="hidden" name="newId" value="'+ localStorage.getItem('newIdUpdate') +'"/>');
      $('#newsForm').attr('action', '{{route("updateNew")}}')
    }

    var audioFile = $('input[name=audio-file]').val();
    var files_type = $('#file_type').val();

    if(!audioFile && (files_type === 'audio' || files_type === 'video'))
    {
      $('.show-audio-error').fadeIn();
      return;
    }
    else
    {
      $('.show-audio-error').fadeOut();
    }

    $('#newsForm').submit();
  })

  // function runScript()
  // {
  //   $('form[name=searchForm]').submit();
  // }

  $('span.trigger_search').click(function(){
    $('form[name=searchForm]').submit();
  });

  function quickNews(id, action)
  {
    if(id)
    {
      fillDataForm(id, action);
    }
    $('select[name="new_type"]').select2('val', 'basic');
    $('select[name="new_type"]').trigger('change');
    $('#newModal').modal('show');
  }

  // function doSomething()
  // {
  //   form = $("form[name=quickCreateNew]").submit();
  // }
</script>

<script type="text/javascript">
  $('.approve-new').click(function (){
      $('#myModal').modal('show');
  });

  function copy(id)
  {
    $('form[id=copyNew'+id+']').submit();
  }

  function noticeApprove(id)
  {
    $('form[id=noticeApprove'+id+']').submit();
  }

  function deleteNew(id)
  {
    // $('.modal-body').text('Bạn có chắc muốn xóa nội dung này không?')
    // $('#myModal').modal('show');

    // return;

    $('form[id=deleteNew' + id +']').submit();
  }

  function noticeApprove(id)
  {
    $('form[id=noticeApprove'+id+']').submit();
  }


  function doSomething(id)
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

  function fillDataPreviewNew(id)
  {
    $.ajax({
      url : "{{route('getPreview')}}",
      data: {newId : id},
      type : 'POST',
    }).done(function(res)
    {
        res = res.new ? JSON.parse(res.new) : res;
        console.log(res);
       $('.new-title').text(res.title ? res.title : '');
       $('.new-created').text(res.created_at ? res.created_at : ''); 
       $('.new-username').text(res.username ? res.username : res.user_id); 
       $('.new-place').text(res.place !== '' ? res.place : res.address);
       $('.new-status').text(res.status ? res.status : '');
       $('.new-publish-at').text(res.publish_time ? res.publish_time : '');
       $('video>source').attr('src', res.audio_path ? res.audio_path : '');
       $('video').load();
       $('embed').attr('src', res.attach_path_file ? res.attach_path_file : '');
       $('.new-text').text(res.audio_text ? res.audio_text : '');
    });
  }

  function preview(id)
  {
    if (id)
      fillDataPreviewNew(id);
    
    $('#previewModal').modal('show');
  }

</script>
<style>
  .table thead > tr > th {
    background: #f0ad4e;
    color : white;
    font-weight: bold;
  }
</style>

@includeIf('partials.search_styles')
@endsection