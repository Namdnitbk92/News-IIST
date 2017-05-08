@extends('layouts.app')
@section('content')
<div class="contentpanel">
      
      <div class="row">
        <div class="col-sm-3">
          <img src="images/user-icon.png" class="thumbnail img-responsive" alt="">
          <h5 class="subtitle">Address</h5>
          <address>
            {{isset($user) ? $user->address : ''}}<br>
          </address>
          
        </div><!-- col-sm-3 -->
        <div class="col-sm-9">
          
          <div class="profile-header">
            <h2 class="profile-name">{{isset($user) ? $user->name : ''}}</h2>
            <div class="profile-location"><i class="fa fa-map-marker"></i> {{\Auth::user()->getAddressByUser()}}</div>
            <div class="profile-location"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i> {{isset($user) ? $user->email : ''}}</div>
            @if(!is_null($user->role_id))
            <div class="profile-location"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i> {{(empty($user->role()) && empty($user->role()->first())) ? '' : $user->role()->first()->description}}</div>
            <div class="profile-position"><i class="fa fa-briefcase"></i> {{( empty($user->role()) && empty($user->role()->first())) ? '' : $user->role()->first()->description}} at  <a href="">Loa phuong channel</a></div>
            @endif
            <div class="mb20"></div>
            
            <button onclick="editProfile();" class="btn btn-success mr5"><i class="fa fa-edit"></i> Chỉnh sửa thông tin người dùng</button>
          </div><!-- profile-header -->
          
          <!-- Nav tabs -->
       <!--  <ul class="nav nav-tabs nav-justified nav-profile">
          <li class="active"><a href="#activities" data-toggle="tab"><strong>Activities</strong></a></li>
          <li><a href="#followers" data-toggle="tab"><strong>Followers</strong></a></li>
        </ul> -->
        
        <!-- Tab panes -->
        </div><!-- col-sm-9 -->
      </div><!-- row -->
      
    </div>

    <script type="text/javascript">
      function editProfile()
      {
        window.location.href = "{{route('editProfile', ['id' => \Auth::user()->id])}}";
      }
    </script>
    @endsection