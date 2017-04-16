@extends('layouts.app')
@section('content')
@includeIf('partials.result')

<div class="table-responsive-vertical shadow-z-1">
  <table id="countyTable" class="table table-hover table-mc-light-blue table-bordered table-stripped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>City</th>
          <th>Supervisor</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      @if(isset($countyList) && count($countyList) > 0)
      	@foreach($countyList as $county)
		     <tr onclick="redirect('{{$county->id}}')">
	          <td data-title="ID">{{ $county->id }}</td>
	          <td data-title="Name">{{ $county->name }}</td>
            <td data-title="City">{{ $county->city()->first()->name }}</td>
	          <td data-title="Supervisor">
	            {{ $county->user()->first()->name }}
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
 {{ $countyList->render() }}
<script type="text/javascript">
	// Show aciton upon row hover
    jQuery('#countyTable tbody tr').hover(function(){
      jQuery(this).find('.table-action-hide a').animate({opacity: 1});
    },function(){
      jQuery(this).find('.table-action-hide a').animate({opacity: 0});
    });

</script>

@endsection