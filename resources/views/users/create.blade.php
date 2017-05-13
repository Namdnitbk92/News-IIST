<div id="message" class="alert alert-success hide"></div>
<form method="POST" name="formUsers" action="{{isset($user) ? route('users.update', ['id' => $user->id]) : route('users.store')}}">
	{{csrf_field()}}
	@if(isset($user))
	  {{ method_field('PUT') }}
	@endif
	<div class="row mb10">
	    <div class="col-sm-6">
	    	<label class="control-label">{{trans('app.name')}}<label class="asterisk">*</label></label>
	        <input  placeholder="" type="name" name="name" class="form-control {{ addErrorClass($errors, 'name') }}" value="{{isset($user) ? $user->name : ''}}" required>
	        {!! displayFieldError($errors, 'name') !!}
	    </div>
	    <div class="col-sm-6">
	    	<label class="control-label">{{trans('app.address')}}</label>
	    	<input placeholder="" type="text" name="address" class="form-control" value="{{isset($user) ? $user->address : ''}}" required>
	    </div>
	</div>

	<div class="row mb10">
	    <div class="col-sm-6">
	    	<label class="control-label">{{trans('app.email')}}<label class="asterisk">*</label></label>
	        <input placeholder="email@example.com" type="email" name="email" class="form-control {{ addErrorClass($errors, 'email') }}" value="{{isset($user) ? $user->email : ''}}" {{isset($user) ? "disabled" : ""}} required>
	        {!! displayFieldError($errors, 'email') !!}
	    </div>
	    <div class="col-sm-6">
	    	<label class="control-label">{{trans('app.role')}}<label class="asterisk">*</label></label>
	    	{!! renderSelect(array_merge($roles->toArray(), ['isDisabled' => isset($user)]), 'role_id', 'description', 'role_id', 'role_id' ,'select2 required') !!}
	    </div>
	</div>

	<div class="row mb10">
	    <div class="col-sm-6">
	    	<label class="control-label">{{trans('app.password')}}<label class="asterisk">*</label></label>
	        <div class="input-group">
               <span class="input-group-addon see-pw" style="color: #428bca;">
                  <i class="fa fa-eye"></i>
               </span>
               <div class="input-group">
                  <input id="password" name="password" type="password" class="form-control {{ addErrorClass($errors, 'password') }}" required/>
               </div>
            </div>
            {!! displayFieldError($errors, 'password') !!}
	    </div>
	    @if(\Auth::user()->belong_to_place !== 'guild')
	    <div class="col-sm-6">
	    	<label class="control-label">Khu vực<label class="asterisk">*</label></label>
	    	<select class="select2 required" id="place_type" name="place_type" >
	          <option value="">Hãy chọn khu vực</option>
	          @if(\Auth::user()->belong_to_place === 'city')
	          	<option value="city">Thành phố</option>
		        <option value="county">Quận</option>
	          @elseif(\Auth::user()->belong_to_place === 'county')
	          	<option value="county">Quận</option>
		        <option value="guild">Phường</option>
	          @endif
	        </select>
	    	
	    </div>
	    @endif
	</div>
	<div class="row mb10">
	    <div class="col-sm-6">
	   	</div>
		<div class="col-sm-6">
			<div class="city_list" style="display:none;">
		      <label class="control-label">&nbsp;&nbsp; Danh sách thành phố</label>
	        	{!! renderSelect($cities, 'id', 'name', 'original_place_id[0]', 'city' ,'select2 required') !!}
		    </div>
		                
		    <div class="county_list" style="display:none;">
		      <label class="control-label"> Danh sách quận</label>
		       {!! renderSelect($counties, 'id', 'name', 'original_place_id[1]', 'county' ,'select2 required') !!}
		    </div>
		        
		    <div class="guild_list" style="display:none;">
		      <label class="control-label">Danh sách phường</label>
		       {!! renderSelect($guilds, 'id', 'name', 'original_place_id[2]', 'guild' ,'select2 required') !!}
		    </div>
	   	</div>
	</div>   		   	

	<br>

	<div class="row mb10">
	    <div class="col-sm-3">
	    	<!-- <button class="btn btn-success btn-block" type="submit">
	    		<i class="fa fa-check"></i>&nbsp;
	    	</button> -->
	    </div>
	</div>    
</form>

<script type="text/javascript">
	$("select[name=role_id]").select2({
	    width: '100%',
	 });
	$("select[name=place_type]").select2({
	    width: '100%',
	 });
	$("#city").select2({
	    width: '100%',
	 });

	$("#county").select2({
	    width: '100%',
	 });

	$("#guild").select2({
	    width: '100%',
	 });

	function showError(flag)
	{
		if (flag === true)
		{	
			$('#message').removeClass('hide');
		    $('#message').addClass('show');
			$('#message').html('<i class="fa fa-remove"></i>&nbsp;&nbsp;Bạn không đủ quyền!');
	        $('#message').removeClass('alert-success');
	        $('#message').addClass('alert-danger');
	        $('#btn-block').attr('disabled', true);
    	}
    	else
    	{
    		$('#message').removeClass('show');
		    $('#message').addClass('hide');
			$('#btn-block').attr('disabled', false);
    	}
	}
	
	@if(isset($user))
		$("select[name=role_id]").select2('val', parseInt('{{ $user->role_id }}'));
	@endif

	// $("select[name=role_id] option[value='6']").remove();

	$('select[name=place_type]').change(function (e){
		var type = $('select[name=place_type]').val();
		var role = $('select[name=role_id]').val();
		var userPlace = '{{\Auth::user()->belong_to_place}}';
		if (type === 'city')
		{
			$('.guild_list').hide();
			$('.county_list').hide();
			$('.city_list').show();
			$("select[name=role_id]").select2('enable');
		}
		else if(type === 'county')
		{
			if (userPlace == 'city')
			{
				$("select[name=role_id]").select2('val', '6');
				$("select[name=role_id]").select2('disable');
			}
			else
			{
				$("select[name=role_id]").select2('enable');
			}
							
			$('.guild_list').hide();
			$('.county_list').show();
			$('.city_list').hide();
		}
		else if(type === 'guild')
		{
			$("select[name=role_id]").select2('val', '6');
			$("select[name=role_id]").select2('disable');
			$('.guild_list').show();
			$('.county_list').hide();
			$('.city_list').hide();
		}
		else 
		{
			$('.guild_list').hide();
			$('.county_list').hide();
			$('.city_list').hide();
		}
		if (type == userPlace && role == '{{\Auth::user()->role_id}}')
		{
			showError(true);
		}
		else
		{
			showError(false);
		}
	});

	$('select[name=role_id]').change(function (e){
		var role = $('select[name=role_id]').val();
		var userPlace = '{{\Auth::user()->belong_to_place}}';
		var type = $('select[name=place_type]').val();
		if ((('county' == userPlace || 'city' == userPlace) && role == 1) || (role == 6 && type == userPlace) || (role == 6 && userPlace === 'guild'))
		{console.log('vao')
			showError(true);
		}
		else
		{
			showError(false);
		}
	})

	$('span.see-pw').click(function (){
		var $input = $('input[name=password]');
		var attr = $input.attr('type');

		if(attr === 'text')
			$input.attr('type', 'password');
		else
			$input.attr('type', 'text');
	});

	var $validator = jQuery("form[name=formUsers]").validate({
	    highlight: function(element) {
	      jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
	    },
	    success: function(element) {
	      jQuery(element).closest('.form-group').removeClass('has-error');
	    },
	    rules: {
		    field: {
		      required: true,
		      email: true
		    }
		  }
	 });
</script>
