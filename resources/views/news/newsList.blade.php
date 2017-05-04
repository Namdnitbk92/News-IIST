@extends('layouts.app')
@section('content')
@includeIf('partials.result')
@includeIf('partials.modal', ['message' => trans('app.confirm_approve_new') ])
<div id="message" class="alert alert-success hide"></div>
<div class="panel panel-success">
  <div class="panel-heading">
    <div class="panel-btns">
      <!-- <a href="javascript:void(0)" onclick="quickNews()"><i class="fa fa-plus"></i>&nbsp;&nbsp;{{trans('app.create_new_quickly')}}</a> -->
    </div><!-- panel-btns -->
    <h3 class="panel-title">{{trans('app.list')}}</h3>
  </div>
  <div class="panel-body">
      <div class="input-group">
         <span class="input-group-addon trigger_search" style="color: #428bca;">
            <i class="glyphicon glyphicon-search"></i>
         </span>
         <div class="input-group">
            <form action="{{route('search_news')}}" method="GET" name="searchForm">
              {{ csrf_field() }}
              <input type="search" id="search" name="search" class="form-control" placeholder="" aria-controls="table2">
            </form>
         </div>
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
              <th>Action</th>
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
    	          	<span class="label label-{{$new->status_id == 1 ? 'success' : (
                  $new->status_id == 2 ? 'warning' : 'danger'
                )}}">{{ (is_null($new->status()) || is_null($new->status()->first())) ? '' : $new->status()->first()->description }}</span>
    	          </td>
                <td style="font-size:20px;">
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
                  {!!displayPreview("$new->id") !!}
                  @if(Auth::user()->isCreater())
                    <a {!! addTooltip(trans('app.update_new')) !!} class="panel-edit" href="{{route('news.edit', ['id' => $new->id])}}"><i class="fa fa-edit "></i></a>&nbsp;
                    <a {!! addTooltip(trans('app.copy_new')) !!} class="panel-edit" href="javascript:void(0);" onclick="copy('{{$new->id}}');"><i class="fa fa-files-o" aria-hidden="true"></i></a>&nbsp;
                    <a {!! addTooltip(trans('app.makes_required_approve')) !!} class="panel-edit" href="javascript:void(0);" onclick="noticeApprove('{{$new->id}}');"><i class="fa fa-share" aria-hidden="true"></i></a>&nbsp;
                    <a  {!! addTooltip(trans('app.delete_new')) !!} class="panel-edit" href="javascript:void(0);" onclick="deleteNew('{{$new->id}}');"><i style="color: red;" class="fa fa-trash-o" aria-hidden="true"></i></a>&nbsp;
                    @endif
                    @if(Auth::user()->isApprover())
                    <a {!! addTooltip(trans('app.approve_new')) !!} class="approve-new panel-edit">
                      <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                    </a>
                    @endif
                </td>
    	        </tr>
    		    @endforeach
          @endif  
          </tbody>
        </table>
      </div>
      {{ $news->render() }}
      @if(isset($new))
          <div class="row" style="position: inherit;bottom:10%;">
            <label class="label label-success pull-right">
            {{$quantity ?? 0}} / {{ $new->getTotalRecordsByCreater() }} Records.</label>
          </div>
      @endif
   </div>
</div>
</div>
<style>
.box{
    display: none;
    width: 100%;
    border-radius: 15% solid blue;
}

iframe
{
  top: 50%;
  left: 50%;
  height : 700px;
  margin-top: -20em; /*set to a negative number 1/2 of your height*/
  margin-left: -30em; /*set to a negative number 1/2 of your width*/
}

a:hover + .box,.box:hover{
    display: block;
    position: relative;
    z-index: 100;
    
}

</style>
<script>
	function redirect(id)
	{
		window.location.href = "/news/" + id;
	}

  // function runScript()
  // {
  //   $('form[name=searchForm]').submit();
  // }

  $('span.trigger_search').click(function(){
    $('form[name=searchForm]').submit();
  });

  // function quickNews()
  // {
  //   $('#myModal').modal('show');
  // }

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

</script>
@endsection