@extends('layouts.app')
@section('content')
@includeIf('partials.modal', ['message' => trans('app.confirm_del_county')])
@includeIf('partials.result')
<div class="panel panel-success">
  <div class="panel-heading">
    <div class="panel-btns">
        <a href="{{route('county.create')}}" class="panel-add"><i class="fa fa-plus"></i>&nbsp;&nbsp;{{trans('app.create_new_entity')}}</a>
    </div><!-- panel-btns -->
    <h3 class="panel-title">{{trans('app.list')}}</h3>
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
  <table id="countyTable" class="table table-hover table-mc-light-blue table-bordered table-stripped">
      <thead>
        <tr>
          <th>{{trans('app.id')}}</th>
          <th>{{trans('app.name')}}</th>
          <th>{{trans('app.city')}}</th>
          <th>{{trans('app.supervisor')}}</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      @if(isset($countyList) && count($countyList) > 0)
      	@foreach($countyList as $county)
		     <tr>
	          <td data-title="ID">{{ $county->id }}</td>
	          <td data-title="Name">{{ $county->name }}</td>
            <td data-title="City">{{ (is_null($county->city()) || is_null($county->city()->first())) ? '' : $county->city()->first()->name }}</td>
	          <td data-title="Supervisor">
	            {{ (is_null($county->user()) || is_null($county->user()->first())) ? '' : $county->user()->first()->name }}
	          </td>
	          <td class="table-action-hide" style="font-size: 20px;">
                   <a href="javascript:void(0)" onclick="editCounty('{{$county->id}}')" style="opacity: 0;"><i class="fa fa-pencil"></i></a>
                   <a href="javascript:void(0)" onclick="deleteCounty('{{$county->id}}')" class="delete-row" style="opacity: 0;">
                    <i class="fa fa-trash-o"></i>
                   </a>
                 <form name="formEdit{{$county->id}}" action="{{route('county.edit', ['id' => $county->id])}}" method="GET">
                    {{csrf_field()}}
                 </form>
                 <form name="formDel{{$county->id}}" action="{{route('county.destroy', ['id' => $county->id])}}" method="POST">
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
 {{ $countyList->render() }}

   </div>
</div>
<script type="text/javascript">
	// Show aciton upon row hover
    jQuery('#countyTable tbody tr').hover(function(){
      jQuery(this).find('.table-action-hide a').animate({opacity: 1});
    },function(){
      jQuery(this).find('.table-action-hide a').animate({opacity: 0});
    });

    function deleteCounty(id)
    {
      localStorage.setItem('countyId', id);
      $('#myModal').modal('show');
    }

    function editCounty(id)
    {
      if(id)
        $('form[name=formEdit'+ id +']').submit();
    }

    function doSomething()
    {
      var id = localStorage.getItem('countyId');
      if (id)
        $('form[name=formDel'+ id +']').submit();
    }

</script>

@endsection