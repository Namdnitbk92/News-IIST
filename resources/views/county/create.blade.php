@extends('layouts.app')
@section('content')
@includeIf('partials.result')
<form method="POST" action="{{isset($county) ? route('county.update', ['id' => $county->id]) : route('county.store')}}">
	{{csrf_field()}}
	@if(isset($county))
	  {{ method_field('PUT') }}
	@endif
	<div class="row mb10">
	    <div class="col-sm-6">
	    	<label class="control-label {{ addErrorClass($errors, 'name') }}">{{trans('app.name')}}</label>
	        <input type="name" name="name" class="form-control" value="{{isset($county) ? $county->name : ''}}">
	        {!! displayFieldError($errors, 'name') !!}
	    </div>
	    <div class="col-sm-6">
	    	<label class="control-label">{{trans('app.county')}}</label>
	         {!! renderSelect($city, 'id', 'name', 'city_id', 'city_id' ,'select2') !!}
	    </div>
	</div>

	<div class="row">
		<div class="col-sm-12">
	    	<label class="control-label">{{trans('app.supervisor')}}</label>
	         {!! renderSelect($users, 'id', 'name', 'supervisor', 'supervisor' ,'select2') !!}
	    </div>
	</div>

	<br>

	<div class="row mb10">
	    <div class="col-sm-3">
	    	<button class="btn btn-success btn-block" type="submit">
	    	<i class="fa fa-check"></i>&nbsp;
	    	{{isset($county) ? trans('app.edit_new_entity') : trans('app.create_new_entity') }}</button>    
	    </div>
	</div>    
</form>

<script type="text/javascript">
	$("select[name=city_id]").select2({
	    width: '100%',
	 });

	$("select[name=supervisor]").select2({
	    width: '100%',
	 });
	@if(isset($county))
		$("select[name=city_id]").select2('val', parseInt('{{ isset($county) ? $county->city_id : 1 }}'));

		$("select[name=supervisor]").select2('val', parseInt('{{ isset($county) ? $county->user()->first()->id : 1 }}'));
	@endif
</script>
@endsection