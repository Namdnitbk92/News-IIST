<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Loa phuong</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/libs.css') }}">
    <!-- Scripts -->
    <script src="{{ asset('js/libs.js') }}"></script>
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</head>
@if (!Auth::guest())
    
<body>
<!-- Preloader -->
<div id="preloader">
    <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
</div>
<section>
  
  <div class="leftpanel">
    <div class="logopanel">
        <h1><span>[</span><i class="fa fa-bullhorn" aria-hidden="true"></i>&nbsp; Loa phường  <span>]</span></h1>
    </div><!-- logopanel -->
    
    <div class="leftpanelinner">
        
        <!-- This is only visible to small devices -->
        <div class="visible-xs hidden-sm hidden-md hidden-lg">   
            <div class="media userlogged">
                <img alt="" src="images/photos/loggeduser.png" class="media-object">
                <div class="media-body">
                    <h4>John Doe</h4>
                    <span>"Life is so..."</span>
                </div>
            </div>
          
            <h5 class="sidebartitle actitle">Account</h5>
            <ul class="nav nav-pills nav-stacked nav-bracket mb30">
              <li><a href="profile.html"><i class="fa fa-user"></i> <span>Profile</span></a></li>
              <li><a href="signout.html"><i class="fa fa-sign-out"></i> <span>Sign Out</span></a></li>
            </ul>
        </div>
      
      <h5 class="sidebartitle"></h5>
      <ul class="nav nav-pills nav-stacked nav-bracket">
        <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> <span>Trang chủ</span></a></li>
        @if(Auth::user()->isCreater() || Auth::user()->isAdmin())
        <li><a href="{{ route('news.index') }}"><i class="fa fa-edit"></i> <span>{{trans('app.news_management')}}</span></a>
          <!-- <ul class="children" style="display: block"> -->
            <!-- <li class="active"><a href="{{ route('news.create') }}"><i class="fa fa-caret-right"></i> {{trans('app.create_new')}}</a></li> -->
            <!-- <li ><a href="{{ route('news.index') }}">{{trans('app.news_list')}}</a></li> -->
          <!-- </ul> -->
        </li>
        @endif
        @if(Auth::user()->isUsersManager() || Auth::user()->isAdmin())
        <li>
          <a href="{{ route('users.index') }}"><i class="fa fa-user"></i> <span>{{trans('app.users_management')}}</span></a>
          <!-- <ul class="children" style="display: block">
            <li class="active"><a href="{{ route('users.create') }}"><i class="fa fa-caret-right"></i>{{trans('app.create_new_entity')}}</a></li>
            <li ><a href="{{ route('users.index') }}"><i class="fa fa-caret-right"></i> {{trans('app.list')}}</a></li>
          </ul> -->
        </li>
        @endif
        @if(Auth::user()->isCreater())
        <li>
          <a href="{{ route('getNewListAvaiableApprove') }}"><i class="fa fa-check"></i> <span>{{trans('app.approve_management')}}</span></a>
        </li>
        @elseif(Auth::user()->isApprover())
        <li ><a href="{{ route('getRequireToApproveNewsListByCreater') }}"><i class="fa fa-check"></i>{{trans('app.list_required_approve')}} </a></li>
        @endif
        @if(Auth::user()->isApprover() || Auth::user()->isAdmin())
        <!-- <li class="nav-parent nav-active active">
          <a href=""><i class="fa fa-users" aria-hidden="true"></i> <span>{{trans('app.groups_management')}}</span></a>
          <ul class="children" style="display: block">
            <li class="active"><a href="{{ route('city.index') }}"><i class="fa fa-caret-right"></i>{{trans('app.city')}}</a></li>
            <li ><a href="{{ route('county.index') }}"><i class="fa fa-caret-right"></i>{{trans('app.county')}}</a></li>
            <li ><a href="{{ route('guild.index') }}"><i class="fa fa-caret-right"></i>{{trans('app.guild')}}</a></li>
          </ul>
        </li> -->
        @endif
      </ul>
    </div><!-- leftpanelinner -->
  </div><!-- leftpanel -->
  
  <div class="mainpanel">
    
    <div class="headerbar">
      
      <a class="menutoggle"><i class="fa fa-bars"></i></a>
      
      <!-- <form class="searchform" action="index.html" method="post">
        <input type="text" class="form-control" name="keyword" placeholder="Search here..." />
      </form> -->
      
      <div class="header-right">
        <ul class="headermenu">
          <li>
            <div class="btn-group">
              <button class="btn btn-default dropdown-toggle tp-icon" data-toggle="dropdown">
                <i class="glyphicon glyphicon-globe"></i>
                <span class="badge notifications">0</span>
              </button>
              <div class="ntfList dropdown-menu dropdown-menu-head pull-right">
                
              </div>
            </div>
          </li>
          <li>
            <div class="btn-group">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <img src="images/photos/loggeduser.png" alt="" />
                {{ Auth::user()->name }}
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                <li><a href="{{route('profile')}}"><i class="glyphicon glyphicon-user"></i> {{trans('app.profile')}}</a></li>
                <li><a href="{{route('showLanguage')}}"><i class="fa fa-language" aria-hidden="true"></i>&nbsp; {{trans('app.language')}}</a></li>
                <li onclick="logout();"><a href="javascript:void(0)"><i class="glyphicon glyphicon-log-out"></i> {{trans('app.logout')}}</a></li>
              </ul>
              <form action="{{route('logout')}}" method="POST" name="formLogout">{{csrf_field()}}</form>
            </div>
          </li>
          @if(session()->has('showChannel'))
          <li>
            <button id="chatview" class="btn btn-default tp-icon chat-icon">
                <i class="glyphicon glyphicon-comment"></i>
            </button>
          </li>
          @endif
        </ul>
      </div><!-- header-right -->
      
    </div><!-- headerbar -->
        
    <div class="pageheader">
      <h2><i class="fa fa-list"></i>{{ isset($titlePage) ? $titlePage : session('titlePage') }}<span></span></h2>
      <div class="breadcrumb-wrapper">
      </div>
    </div>
    
    <div class="contentpanel">
      @yield('content')
      @yield('page-script')
    </div>
    
  </div><!-- mainpanel -->
  
  <div class="rightpanel">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs nav-justified">
        <li class="active"><a href="#rp-alluser" data-toggle="tab"><i class="fa fa-users"></i></a></li>
        <li><a href="#rp-favorites" data-toggle="tab"><i class="fa fa-heart"></i></a></li>
        <li><a href="#rp-history" data-toggle="tab"><i class="fa fa-clock-o"></i></a></li>
        <li><a href="#rp-settings" data-toggle="tab"><i class="fa fa-gear"></i></a></li>
    </ul>
        
    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active" id="rp-alluser">
            <h5 class="sidebartitle">Online Users</h5>
            <div class="mb30"></div>
            <h5 class="sidebartitle">Offline Users</h5>
        </div>
        <div class="tab-pane" id="rp-favorites">
        </div>
        <div class="tab-pane" id="rp-history">
        </div>
        <div class="tab-pane pane-settings" id="rp-settings">
        </div><!-- tab-pane -->
        
    </div><!-- tab-content -->
  </div><!-- rightpanel -->
  
</section>
</body>
@elseif (strpos(Route::getCurrentRoute()->getPath(), 'password/reset') !== false)
    @yield('passwordReset')
@elseif (Route::getCurrentRoute()->getPath() === 'register')
    @yield('register')
@else
    @yield('login')
@endif
</html>
<script>
  function logout()
  {
    $('form[name=formLogout]').submit();
  }

  $.ajax({
    url : '{{route("getNotifications")}}',
    method : 'GET',
  }).done(function (res){
    if (res && res.totalNotifications)
      $('span.notifications').text(res.totalNotifications);
      $('.ntfList').append('<h5 class="title">You Have ' + res.totalNotifications +' New Notifications</h5>');

      if (res && res.news.length)
        for (var i = res.news.length - 1; i >= 0; i--) {
          var $new = res.news[i];
          var html = '<a href="/news/'+$new.id+'"><ul class="dropdown-list gen-list">'
                +  '<li class="new">'
                +    '<a href="">'
                +    '<span class="thumb"><img src="images/photos/user4.png" alt="" /></span>'
                +   '<span class="desc">'
                +      '<span class="name">' + $new.title + '<span class="badge badge-success">new</span></span>'
                +     '<span class="msg">is now following you</span>'
                +   '</span>'
                +    '</a>'
                +  '</li>'
                +  '<li class="new"><a href="">See All Notifications</a></li>'
                + '</ul>';

          $('.ntfList').append(html);
        }
  })

  localStorage.clear();


  $.extend( $.validator.messages, {
    required: "Trường bắt buộc.",
    remote: "Hãy sửa cho đúng.",
    email: "Hãy nhập email.",
    url: "Hãy nhập URL.",
    date: "Hãy nhập ngày.",
    dateISO: "Hãy nhập ngày (ISO).",
    number: "Hãy nhập số.",
    digits: "Hãy nhập chữ số.",
    creditcard: "Hãy nhập số thẻ tín dụng.",
    equalTo: "Hãy nhập thêm lần nữa.",
    extension: "Phần mở rộng không đúng.",
    maxlength: $.validator.format( "Hãy nhập từ {0} kí tự trở xuống." ),
    minlength: $.validator.format( "Hãy nhập từ {0} kí tự trở lên." ),
    rangelength: $.validator.format( "Hãy nhập từ {0} đến {1} kí tự." ),
    range: $.validator.format( "Hãy nhập từ {0} đến {1}." ),
    max: $.validator.format( "Hãy nhập từ {0} trở xuống." ),
    min: $.validator.format( "Hãy nhập từ {1} trở lên." )
  } );

 $.validator.addMethod("valueNotEquals", function(value, element, arg){
    return arg != value;
 }, "Value must not equal arg.");


</script>