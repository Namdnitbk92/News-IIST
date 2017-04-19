@extends('layouts.app')
@section('content')
@includeIf('partials.result')
@includeIf('partials.modal', ['message' => 'Are you sure delete this guild ?'])
<div class="panel panel-success">
  <div class="panel-heading">
    <div class="panel-btns">
        <a href="{{route('guild.create')}}" class="panel-add"><i class="fa fa-plus"></i>&nbsp;&nbsp;New guild</a>
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
        <table id="guildTable" class="table table-hover table-mc-light-blue table-bordered table-stripped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>County</th>
                <th>Supervisor</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            @if(isset($guildList) && count($guildList) > 0)
            	@foreach($guildList as $guild)
      		     <tr>
      	          <td data-title="ID">{{ $guild->id }}</td>
      	          <td data-title="Name">{{ $guild->name }}</td>
                  <td data-title="County">{{ (is_null($guild->county()) || is_null($guild->county()->first())) ? '' : $guild->county()->first()->name }}</td>
      	          <td data-title="Supervisor">
      	            {{ (is_null($guild->user()) || is_null($guild->user()->first())) ? '' :  $guild->user()->first()->name }}
      	          </td>
      	          <td class="table-action-hide" style="font-size: 20px;">
      	          	 <a href="javascript:void(0)" onclick="editGuild('{{$guild->id}}')" style="opacity: 0;"><i class="fa fa-pencil"></i></a>
                       <a href="javascript:void(0)" onclick="deleteGuild('{{$guild->id}}')" class="delete-row{{$guild->id}}" style="opacity: 0;">
                       	<i class="fa fa-trash-o"></i>
                       </a>
                       <form name="formEdit{{$guild->id}}" action="{{route('guild.edit', ['id' => $guild->id])}}" method="GET">
                          {{csrf_field()}}
                       </form>
                       <form name="formDel{{$guild->id}}" action="{{route('guild.destroy', ['id' => $guild->id])}}" method="POST">
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
       {{ $guildList->render() }}



   </div>
</div>
<script type="text/javascript">
	// Show aciton upon row hover
    jQuery('#guildTable tbody tr').hover(function(){
      jQuery(this).find('.table-action-hide a').animate({opacity: 1});
    },function(){
      jQuery(this).find('.table-action-hide a').animate({opacity: 0});
    });

    function deleteGuild(id)
    {
      localStorage.setItem('guidId', id);
      $('#myModal').modal('show');
    }

    function editGuild(id)
    {
      if(id)
        $('form[name=formEdit'+ id +']').submit();
    }

    function doSomething()
    {
      var id = localStorage.getItem('guidId');
      if (id)
        $('form[name=formDel'+ id +']').submit();
    }

    $('a.panel-add').hover(function (){

    })

</script>

@endsection