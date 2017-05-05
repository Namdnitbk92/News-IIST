@if (session('status'))
  <div class="alert alert-success _message">
      <i class="fa fa-thumbs-up" aria-hidden="true"></i>&nbsp;{{ session('status') }}
  </div>

@elseif (session('error'))
	<div class="alert alert-danger _message">
      <label><i class="fa fa-times" aria-hidden="true"></i>&nbsp; {{ session('error') }} </label>
  </div>

@elseif (isset($errors) && count($errors) > 0)
	<div class="alert alert-danger _message">
		@foreach($errors->all() as $error)
			<p><label><i class="fa fa-times" aria-hidden="true"></i>&nbsp; {{$error}}</label></p>
		@endforeach
  </div>
@endif

<script type="text/javascript">
	// setTimeout(function (){$('._message').hide(2000);}, 3000);
</script>