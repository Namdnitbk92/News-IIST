@extends('layouts.app')
@section('content')
@includeIf('partials.result')
 <div id="demo">
  <div style="float:right;">
    <form class="searchform" action="index.html" method="post">
        <input type="text" class="form-control" name="keyword" placeholder="Search here...">
      </form>
    <form action="{{route('search_news')}}" method="GET">
      {{ csrf_field() }}
      <label>Search <input onkeypress="return runScript()" type="search" id="search" name="search" class="" placeholder="" aria-controls="table2"></label>
    </form>  
  </div>
  <div class="table-responsive-vertical shadow-z-1">
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
            )}}">{{ $new->status()->first()->description }}</span>
	          </td>
	        </tr>
		    @endforeach
      @endif  
      </tbody>
    </table>
  </div>
  {{ $news->render() }}
  @if(isset($new))
      <div class="row">
        <label class="label label-success pull-right" style="margin: -6% 0 0 0;">{{ $new->getTotalRecords() }} Records.</label>
      </div>
  @endif
</div>

<script>
	function redirect(id)
	{
		window.location.href = "/news/" + id;
	}

  function runScript()
  {
    document.getElementById('#search').submit();
  }
</script>
@endsection