@extends('layouts.app')
@section('content')
@includeIf('partials.result')
<form method="POST" action="{{isset($city) ? route('city.update', ['id' => $city->id]) : route('city.store')}}">
	{{csrf_field()}}
	@if(isset($city))
	  {{ method_field('PUT') }}
	@endif
	<div class="row">
	    <div class="col-sm-12">
	    	<label class="control-label">City Name</label>
	        <input type="name" name="name" class="form-control" value="{{isset($city) ? $city->name : ''}}">
	    </div>
	</div>

	<div class="row">
		<div class="col-sm-12">
	    	<label class="control-label">Supervisor</label>
	         {!! renderSelect($users, 'id', 'name', 'supervisor', 'supervisor' ,'select2') !!}
	    </div>
	</div>

	<br>

	<div class="row mb10">
	    <div class="col-sm-3">
	    	<button class="btn btn-success btn-block" type="submit">
	    	<i class="fa fa-check"></i>&nbsp;
	    	{{isset($city) ? 'Update City' : 'Create City' }}</button>    
	    </div>
	</div>    
</form>

<script type="text/javascript">
	
	$("select[name=supervisor]").select2({
	    width: '100%',
	 });

	$("select[name=supervisor]").select2('val', parseInt('{{ isset($city) ? $city->user()->first()->id : 1 }}'));
</script>
@endsection