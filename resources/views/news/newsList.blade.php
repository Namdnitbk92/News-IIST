@extends('layouts.app')

@section('content')
	 
  @if (session('status'))
      <div class="alert alert-success">
          {{ session('status') }}
      </div>
  @endif
 <div id="demo">
  <h1>News List</h1>
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
      	@foreach($news as $new)
			<tr onclick="redirect('{{$new->id}}')">
	          <td data-title="ID">{{ $new->id }}</td>
	          <td data-title="Title">{{ $new->title }}</td>
	          <td data-title="SubTitle">
	            {{ $new->sub_title }}
	          </td>
	          <td data-title="Status">
	          	<span class="label label-success">{{ $new->status()->first()->description }}</span>
	          </td>
	        </tr>
		@endforeach
      </tbody>
    </table>
  </div>
  {{ $news->render() }}
</div>

<script>
	function redirect(id)
	{
		window.location.href = "/news/" + id;
	}
</script>
@endsection