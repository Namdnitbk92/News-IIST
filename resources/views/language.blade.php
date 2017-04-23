@extends('layouts.app')
@section('content')
@includeIf('partials.result')
<div class="panel panel-success">
  <div class="panel-heading">
    <div class="panel-btns">
    </div><!-- panel-btns -->
    <h3 class="panel-title">Change language</h3>
  </div>
  <div class="panel-body">
  	<form action="{{route('showLanguage')}}" method="POST">
  		{{csrf_field()}}
	  	<div class="row">
			<div class="col-sm-12">
		    	<label class="control-label">Languages</label>
		         {!! renderSelect($languages, 'id', 'name', 'language', 'language' ,'select2') !!}
		    </div>
		</div>
		<div class="row">
			<br>
		</div>
		<div class="row">
		    <div class="col-sm-12">
		    	<button class="btn btn-success btn-block" type="submit">
		    	<i class="fa fa-check"></i>&nbsp;
		    	Change
		    	</button>    
		    </div>
		</div>
	</form>   
  </div>
</div>

<script type="text/javascript">
	$("select[name=language]").select2({
	    width: '100%',
	 });
</script>
@endsection