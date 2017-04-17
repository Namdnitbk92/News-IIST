@extends('layouts.app')
@section('content')
@includeIf('partials.result')

<div class="panel panel-success">
  <div class="panel-heading">
    <div class="panel-btns">
        <a href="{{route('guild.create')}}" class="panel-add"><i class="fa fa-plus"></i>&nbsp;&nbsp;New user</a>
    </div><!-- panel-btns -->
    <h3 class="panel-title">List</h3>
  </div>
  <div class="panel-body">
      <div class="input-group">
         <span class="input-group-addon" style="color: #428bca;">
            <i class="glyphicon glyphicon-search"></i>
         </span>
         <div class="input-group">
            <input id="tableSearch" name="tableSearch" type="text" class="form-control"/>
         </div>
      </div>

<div class="table-responsive-vertical shadow-z-1" style="padding-top:1%;">
  <table id="userTable" class="table table-hover table-mc-light-blue table-bordered table-stripped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      @if(isset($users) && count($users) > 0)
      	@foreach($users as $user)
		     <tr onclick="redirect('{{$user->id}}')">
	          <td data-title="ID">{{ $user->id }}</td>
	          <td data-title="Name">{{ $user->name }}</td>
	          <td data-title="Role">
	            {{ $user->email }}
	          </td>
	          <td class="table-action-hide">
	          	 <a href="" style="opacity: 0;"><i class="fa fa-pencil"></i></a>
                 <a href="" class="delete-row" style="opacity: 0;">
                 	<i class="fa fa-trash-o"></i>
                 </a>
	          </td>
	        </tr>
		    @endforeach
      @endif  
      </tbody>
    </table>
  </div>
 {{ $users->render() }}

   </div>
</div>
<script 
<script type="text/javascript">
	// Show aciton upon row hover
    jQuery('#userTable tbody tr').hover(function(){
      jQuery(this).find('.table-action-hide a').animate({opacity: 1});
    },function(){
      jQuery(this).find('.table-action-hide a').animate({opacity: 0});
    });

</script>

@endsection