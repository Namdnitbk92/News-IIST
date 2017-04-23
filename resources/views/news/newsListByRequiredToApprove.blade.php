@extends('layouts.app')
@section('content')
@includeIf('partials.modal', ['message' => trans('app.confirm_remove_approve')])
@includeIf('partials.result')
<div class="panel panel-success">
  <div class="panel-heading">
    <div class="panel-btns">
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
          <th>{{trans('app.title')}}</th>
          <th>{{trans('app.description')}}</th>
          <th>{{trans('app.status')}}</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      @if(isset($news) && count($news) > 0)
      	@foreach($news as $new)
		     <tr>
	          <td data-title="ID">{{ $new->id }}</td>
	          <td data-title="Title">{{ $new->title }}</td>
            <td data-title="Subtitle">{{ $new->sub_title }}</td>
	          <td data-title="Status">
	            <span class="label label-{{$new->status_id == 1 ? 'success' : (
                  $new->status_id == 2 ? 'warning' : 'danger'
                )}}">{{ (is_null($new->status()) || is_null($new->status()->first())) ? '' : $new->status()->first()->description }}</span>
	          </td>
	          <td class="table-action-hide" style="font-size:20px;">
                  <a {!! addTooltip('show detail') !!} href="{{route('news.show', ['id' => $new->id])}}" style="opacity: 0;"><i class="fa fa-info"></i></a>
                   <a href="javascript:void(0)" {!! addTooltip('remove this required') !!}  onclick="deleteApproved('{{$new->id}}')" class="delete-row" style="opacity: 0;">
                    <i class="fa fa-trash-o"></i>
                   </a>
                 <form name="formDel{{$new->id}}" action="{{route('deleteApproved')}}" method="POST">
                    {{csrf_field()}}
                    <input type="hidden" name="id" value="{{$new->id}}"/>                    
                 </form>
	          </td>
	        </tr>
		    @endforeach
      @endif  
      </tbody>
    </table>
  </div>
 {{ $news->render() }}

   </div>
</div>
<script type="text/javascript">
	// Show aciton upon row hover
    jQuery('#countyTable tbody tr').hover(function(){
      jQuery(this).find('.table-action-hide a').animate({opacity: 1});
    },function(){
      jQuery(this).find('.table-action-hide a').animate({opacity: 0});
    });

    function deleteApproved(id)
    {
      localStorage.setItem('newId', id);
      $('#myModal').modal('show');
    }
   
    function doSomething()
    {
      var id = localStorage.getItem('newId');
      if (id)
        $('form[name=formDel'+ id +']').submit();
    }

</script>

@endsection