@extends('layouts.app')
@section('content')
@includeIf('partials.search_styles')
@includeIf('partials.result')
@includeIf('partials.modal', ['message' => trans('app.confirm_delete_users')])
<div class="panel panel-success">
  <div class="panel-heading">
    <div class="panel-btns">
        <form style="float:right;" name="searchForm" method="get" action="{{route('search_users')}}" id="search">
        {{ csrf_field() }}
          <input name="search" type="text" size="40" placeholder="Tìm kiếm..." />
        </form>
        <!-- <a href="{{route('users.create')}}" class="panel-add"><i class="fa fa-plus"></i>&nbsp;Thêm mới &nbsp;</a> -->
    </div><!-- panel-btns -->
    <h3 class="panel-title">Danh sách </h3>
  </div>
  <div class="panel-body">
      <!-- <div class="input-group">
         <span class="input-group-addon" style="color: #428bca;">
            <i class="glyphicon glyphicon-search"></i>
         </span>
         <div class="input-group">
            <form action="{{route('search_users')}}" method="GET" name="searchForm">
              {{ csrf_field() }}
              <input type="search" id="search" name="search" class="form-control" placeholder="" aria-controls="table2">
            </form>
         </div>
      </div> -->
      <div class="input-group" style="float:right;padding:5px;">
         @if(Auth::user()->isUsersManager() || Auth::user()->isAdmin())
          <a class="btn btn-primary-alt" href="javascript:void(0)" onclick="popupNewUser()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Thêm mới người dùng</a>
        @endif 
      </div>
<div class="table-responsive-vertical shadow-z-1" style="padding-top:1%;">
  <table id="userTable" class="table table-hover table-mc-light-blue table-bordered table-stripped">
      <thead style="background: #f0ad4e;">
        <tr>
          <th>Tên</th>
          <th>Vai trò</th>
          <th>Địa chỉ mail</th>
          <th>Phạm vi hoạt động</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
      @if(isset($users) && count($users) > 0)
      	@foreach($users as $user)
		     <tr>
	          <td data-title="Name">{{ $user->name }}</td>
            <td data-title="Name">{{ !empty($user->role()) && !empty($user->role()->first()) ? $user->role()->first()->description : ''}}</td>
	          <td data-title="Role">
	            {{ $user->email }}
	          </td>
            <td>{{$user->getAddressByUser()}}</td>
	          <td class="" style="font-size: 20px;width:15%;">

                <a {!! addTooltip('Sửa thông tin người dùng') !!} class="panel-edit btn btn btn-primary-alt" href="javascript:void(0);" onclick="popupNewUser('{{$user->id}}', 'update')"><i class="fa fa-edit" aria-hidden="true"></i></a>&nbsp;

                <a  {!! addTooltip('Xóa người dùng') !!} class="panel-edit btn btn btn-primary-alt" href="javascript:void(0);" onclick="deleteUser('{{$user->id}}')"><i style="color: red;" class="fa fa-trash-o" aria-hidden="true"></i></a>


                 <form name="formEdit{{$user->id}}" action="{{route('users.edit', ['id' => $user->id])}}" method="GET">
                    {{csrf_field()}}
                 </form>
                 <form name="formDel{{$user->id}}" action="{{route('users.destroy', ['id' => $user->id])}}" method="POST">
                    {{csrf_field()}}
                    {{ method_field('DELETE') }}                    
                 </form>
	          </td>
	        </tr>
		    @endforeach
      @else
      <tr><td colspan="5" style="text-align:center;">Không tìm thấy bản ghi</td></tr>
      @endif  
      </tbody>
    </table>
  </div>
 {{ $users->render() }}

   </div>
</div>
<?php unset($user);?>
<!-- Users Modal -->
<div id="userModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="background: #f0ad4e;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title modal-title-user"><i class="fa fa-information"></i>Thêm mới người dùng</h4>
      </div>
      <div class="modal-body">
        @includeIf('users.create')
      </div>
      <div class="modal-footer">
        <button id="btn-block" type="button" class="btn btn-primary" action="create" onclick="save()" ><i class="fa fa-thumbs-o-up"></i>&nbsp;Lưu</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;{{trans('app.close')}}</button>
      </div>
    </div>

  </div>
</div>
<style>
  .table thead > tr > th {
    background: #f0ad4e;
    color : white;
    font-weight: bold;
  }
</style>
<script type="text/javascript">
	// Show aciton upon row hover
    // jQuery('#userTable tbody tr').hover(function(){
    //   jQuery(this).find('.table-action-hide a').animate({opacity: 1});
    // },function(){
    //   jQuery(this).find('.table-action-hide a').animate({opacity: 0});
    // });


    function deleteUser(id)
    {
      localStorage.setItem('userId', id);
      $('#myModal').modal('show');
    }

    function editUser(id)
    {
      if(id)
        $('form[name=formEdit'+ id +']').submit();
    }

    function doSomething()
    {
      var id = localStorage.getItem('userId');
      if (id)
        $('form[name=formDel'+ id +']').submit();
    }
     
    $('span.trigger_search').click(function(){
        $('form[name=searchForm]').submit();
    });

    function fillUserData(id, action)
    {
      if (!id)
        return;

      localStorage.setItem('userIdUpdate', id);
      $('.modal-title-user').text('Sửa thông tin người dùng');
      $.ajax({
        url : '{{route("getUserDetail")}}',
        type: 'POST',
        data : {'userId' : id}
      }).done(function (res){
        if (res && res.user)
        {
          var user = JSON.parse(res.user);
          $('input[name=name]').val(user.name ? user.name : '');
          $('input[name=address]').val(user.address ? user.address : '');
          $('input[name=email]').val(user.email ? user.email : '');
          if(user.role_id)
            $('select[name=role_id]').select2('val', user.role_id);
          $('input[name=password]').val('');
          $('input[name=email]').attr('disabled', true);
          $('select[name=role_id]').select2('enable', false);
          $('select[name=place_type]').select2('enable', false);
          $('#btn-block').attr('action', action);
        }
      });
    }

    function clearForm()
    {
      $('input[name=name]').val('');
      $('input[name=address]').val('');
      $('input[name=email]').val('');
      $('select[name=role_id]').select2('val', '');
      $('input[name=password]').val('');
      $('input[name=email]').removeAttr('disabled');
      $('select[name=role_id]').select2('enable', true);
      $('select[name=place_type]').select2('enable', true);
      $('.modal-title-user').text('Thêm người dùng');
      $('#btn-block').attr('action', 'create');
    }

    function popupNewUser(id, action)
    {
      if (id)
      {
        fillUserData(id, action);
      }

      $('#userModal').modal('show');
    }

    $('#userModal').on('hidden.bs.modal', function () {
      clearForm();
    })

    function save()
    {
      var formUser = $('form[name=formUsers]');
      var action = $('#btn-block').attr('action');
      if (action === 'create')
      {
        formUser.attr('action', '{{route("users.store")}}');
      }
      else 
      {
        formUser.append('<input type="hidden" name="userId" value="'+ localStorage.getItem('userIdUpdate') +'"/>');
        formUser.attr('action', '{{route("updateUser")}}')
      }

      formUser.submit();
    }
</script>

@endsection