@if (session('status'))
  <div class="alert alert-success _message">
      <i class="fa fa-thumbs-up" aria-hidden="true"></i>&nbsp;{{ session('status') }}
  </div>

@elseif (session('error'))
	<div class="alert alert-danger _message">
      <label><i class="fa fa-times" aria-hidden="true"></i>&nbsp; {{ session('error') }} </label>
  </div>
@endif

<script type="text/javascript">
	setTimeout(function (){$('._message').hide(2000);}, 3000);
</script>