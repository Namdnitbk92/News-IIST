@extends('layouts.app')
@section('content')
@includeIf('partials.result')

<div class="table-responsive-vertical shadow-z-1">
  <table id="cityTable" class="table table-hover table-mc-light-blue table-bordered table-stripped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Supervisor</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      @if(isset($cityList) && count($cityList) > 0)
      	@foreach($cityList as $city)
		     <tr onclick="redirect('{{$city->id}}')">
	          <td data-title="ID">{{ $city->id }}</td>
	          <td data-title="Name">{{ $city->name }}</td>
	          <td data-title="Supervisor">
	            {{ $city->user()->first()->name }}
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
 {{ $cityList->render() }}
<script type="text/javascript">
	// Show aciton upon row hover
    jQuery('#cityTable tbody tr').hover(function(){
      jQuery(this).find('.table-action-hide a').animate({opacity: 1});
    },function(){
      jQuery(this).find('.table-action-hide a').animate({opacity: 0});
    });

</script>

@endsection