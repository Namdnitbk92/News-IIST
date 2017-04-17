@extends('layouts.app')
@section('content')
@includeIf('partials.result')
@includeIf('partials.modal', ['message' => 'Are you sure delete this city ?'])
<div class="panel panel-success">
  <div class="panel-heading">
    <div class="panel-btns">
        <a href="{{route('city.create')}}" class="panel-add"><i class="fa fa-plus"></i>&nbsp;&nbsp;New city</a>
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
		     <tr>
	          <td data-title="ID">{{ $city->id }}</td>
	          <td data-title="Name">{{ $city->name }}</td>
	          <td data-title="Supervisor">
	            {{ $city->user()->first()->name }}
	          </td>
	          <td class="table-action-hide">
	          	<a href="javascript:void(0)" onclick="editCity('{{$city->id}}')" style="opacity: 0;"><i class="fa fa-pencil"></i></a>
                   <a href="javascript:void(0)" onclick="deleteCity('{{$city->id}}')" class="delete-row" style="opacity: 0;">
                    <i class="fa fa-trash-o"></i>
                   </a>
                 <form name="formEdit{{$city->id}}" action="{{route('city.edit', ['id' => $city->id])}}" method="GET">
                    {{csrf_field()}}
                 </form>
                 <form name="formDel{{$city->id}}" action="{{route('city.destroy', ['id' => $city->id])}}" method="POST">
                    {{csrf_field()}}
                    {{ method_field('DELETE') }}                    
                 </form>
	          </td>
	        </tr>
		    @endforeach
      @endif  
      </tbody>
    </table>
  </div>
 {{ $cityList->render() }}

  </div>
</div>
<script type="text/javascript">
	// Show aciton upon row hover
    jQuery('#cityTable tbody tr').hover(function(){
      jQuery(this).find('.table-action-hide a').animate({opacity: 1});
    },function(){
      jQuery(this).find('.table-action-hide a').animate({opacity: 0});
    });

    function deleteCity(id)
    {
      localStorage.setItem('cityId', id);
      $('#myModal').modal('show');
    }

    function editCity(id)
    {
      if(id)
        $('form[name=formEdit'+ id +']').submit();
    }

    function doSomething()
    {
      var id = localStorage.getItem('cityId');
      if (id)
        $('form[name=formDel'+ id +']').submit();
    }

</script>

@endsection