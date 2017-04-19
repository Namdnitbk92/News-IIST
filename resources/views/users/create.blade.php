@extends('layouts.app')
@section('content')
@includeIf('partials.result')
<form method="POST" action="{{isset($user) ? route('users.update', ['id' => $user->id]) : route('users.store')}}">
	{{csrf_field()}}
	@if(isset($user))
	  {{ method_field('PUT') }}
	@endif
	<div class="row mb10">
	    <div class="col-sm-6">
	    	<label class="control-label">User Name</label>
	        <input  placeholder="Name for user will be creating" type="name" name="name" class="form-control {{ addErrorClass($errors, 'name') }}" value="{{isset($user) ? $user->name : ''}}">
	        {!! displayFieldError($errors, 'name') !!}
	    </div>
	    <div class="col-sm-6">
	    	<label class="control-label">Address</label>
	    	<input placeholder="exp : Nguyen chi thanh - street,etc...." type="text" name="address" class="form-control" value="{{isset($user) ? $user->address : ''}}">
	    </div>
	</div>

	<div class="row mb10">
	    <div class="col-sm-6">
	    	<label class="control-label">Email</label>
	        <input placeholder="email@example.com" type="email" name="email" class="form-control {{ addErrorClass($errors, 'email') }}" value="{{isset($user) ? $user->email : ''}}" {{isset($user) ? "disabled" : ""}}>
	        {!! displayFieldError($errors, 'email') !!}
	    </div>
	    <div class="col-sm-6">
	    	<label class="control-label">Role</label>
	    	{!! renderSelect(array_merge($roles->toArray(), ['isDisabled' => isset($user)]), 'role_id', 'description', 'role_id', 'role_id' ,'select2') !!}
	    </div>
	</div>

	<div class="row">
	    <div class="col-sm-12">
	    	<label class="control-label">Password</label>
	        <div class="input-group">
               <span class="input-group-addon see-pw" style="color: #428bca;">
                  <i class="fa fa-eye"></i>
               </span>
               <div class="input-group">
                  <input id="password" name="password" type="password" class="form-control {{ addErrorClass($errors, 'password') }}"/>
               </div>
            </div>
            {!! displayFieldError($errors, 'password') !!}
	    </div>
	</div>

	<br>

	<div class="row mb10">
	    <div class="col-sm-3">
	    	<button class="btn btn-success btn-block" type="submit">
	    	<i class="fa fa-check"></i>&nbsp;
	    	{{isset($user) ? 'Update user' : 'Create user' }}</button>    
	    </div>
	</div>    
</form>

<script type="text/javascript">
	$("select[name=role_id]").select2({
	    width: '100%',
	 });

	@if(isset($user))
		$("select[name=role_id]").select2('val', parseInt('{{ $user->role_id }}'));
	@endif

	$('span.see-pw').click(function (){
		var $input = $('input[name=password]');
		var attr = $input.attr('type');

		if(attr === 'text')
			$input.attr('type', 'password');
		else
			$input.attr('type', 'text');
	});
</script>
@endsection