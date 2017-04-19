@extends('layouts.app')
@section('content')
@includeIf('partials.result')
@includeIf('partials.modal', ['message' => isset($formQuickCreateNew) ? $formQuickCreateNew : '', 'btn_custom' => 'Create new quickly', 'header' => 'Create a new quickly'])
<div class="panel panel-success">
  <div class="panel-heading">
    <div class="panel-btns">
      <a href="javascript:void(0)" onclick="quickNews()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Create a new quickly</a>
    </div><!-- panel-btns -->
    <h3 class="panel-title">List</h3>
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


     <!-- <div id="demo">
      <div style="float:right;">
        <form class="searchform" action="index.html" method="post">
            <input type="text" class="form-control" name="keyword" placeholder="Search here...">
          </form>
        <form action="{{route('search_news')}}" method="GET" name="searchForm">
          {{ csrf_field() }}
          <label>Search <input onkeypress="return runScript()" type="search" id="search" name="search" class="" placeholder="" aria-controls="table2"></label>
        </form>  
      </div> -->
      <div class="table-responsive-vertical shadow-z-1" style="padding-top:1%;">
      <table id="table" class="table table-hover table-mc-light-blue table-bordered table-stripped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>SubTitle</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
          @if(isset($news) && count($news) > 0)
          	@foreach($news as $new)
    			     <tr onclick="redirect('{{$new->id}}')">
    	          <td data-title="ID">{{ $new->id }}</td>
    	          <td data-title="Title">{{ $new->title }}</td>
    	          <td data-title="SubTitle">
    	            {{ $new->sub_title }}
    	          </td>
    	          <td data-title="Status">
    	          	<span class="label label-{{$new->status_id == 1 ? 'success' : (
                  $new->status_id == 2 ? 'warning' : 'danger'
                )}}">{{ (is_null($new->status()) || is_null($new->status()->first())) ? '' : $new->status()->first()->description }}</span>
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
            {{$quantity ?? 0}} / {{ $new->getTotalRecords() }} Records.</label>
          </div>
      @endif

   </div>
</div>
</div>

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

  function quickNews()
  {
    $('#myModal').modal('show');
  }

  function doSomething()
{
  form = $("form[name=quickCreateNew]").submit();
}
</script>
@endsection