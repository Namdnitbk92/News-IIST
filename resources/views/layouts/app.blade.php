<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Loa phuong') }}</title>

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
        <h1><span>[</span><i class="fa fa-bullhorn" aria-hidden="true"></i>&nbsp; News <span>]</span></h1>
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
              <li><a href=""><i class="fa fa-cog"></i> <span>Account Settings</span></a></li>
              <li><a href=""><i class="fa fa-question-circle"></i> <span>Help</span></a></li>
              <li><a href="signout.html"><i class="fa fa-sign-out"></i> <span>Sign Out</span></a></li>
            </ul>
        </div>
      
      <h5 class="sidebartitle">Navigation</h5>
      <ul class="nav nav-pills nav-stacked nav-bracket">
        <li><a href="index.html"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
        <li class="nav-parent nav-active active"><a href=""><i class="fa fa-edit"></i> <span>News List</span></a>
          <ul class="children" style="display: block">
            <li class="active"><a href="{{ route('news.create') }}"><i class="fa fa-caret-right"></i> Create a new</a></li>
            <li ><a href="form-layouts.html"><i class="fa fa-caret-right"></i> View list news</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- leftpanelinner -->
  </div><!-- leftpanel -->
  
  <div class="mainpanel">
    
    <div class="headerbar">
      
      <a class="menutoggle"><i class="fa fa-bars"></i></a>
      
      <form class="searchform" action="index.html" method="post">
        <input type="text" class="form-control" name="keyword" placeholder="Search here..." />
      </form>
      
      <div class="header-right">
        <ul class="headermenu">
          <li>
            <div class="btn-group">
              <button class="btn btn-default dropdown-toggle tp-icon" data-toggle="dropdown">
                <i class="glyphicon glyphicon-user"></i>
                <span class="badge">2</span>
              </button>
              <div class="dropdown-menu dropdown-menu-head pull-right">
                <h5 class="title">2 Newly Registered Users</h5>
                <ul class="dropdown-list user-list">
                  <li class="new">
                    <div class="thumb"><a href=""><img src="images/photos/user1.png" alt="" /></a></div>
                    <div class="desc">
                      <h5><a href="">Draniem Daamul (@draniem)</a> <span class="badge badge-success">new</span></h5>
                    </div>
                  </li>
                  <li class="new">
                    <div class="thumb"><a href=""><img src="images/photos/user2.png" alt="" /></a></div>
                    <div class="desc">
                      <h5><a href="">Zaham Sindilmaca (@zaham)</a> <span class="badge badge-success">new</span></h5>
                    </div>
                  </li>
                  <li>
                    <div class="thumb"><a href=""><img src="images/photos/user3.png" alt="" /></a></div>
                    <div class="desc">
                      <h5><a href="">Weno Carasbong (@wenocar)</a></h5>
                    </div>
                  </li>
                  <li>
                    <div class="thumb"><a href=""><img src="images/photos/user4.png" alt="" /></a></div>
                    <div class="desc">
                      <h5><a href="">Nusja Nawancali (@nusja)</a></h5>
                    </div>
                  </li>
                  <li>
                    <div class="thumb"><a href=""><img src="images/photos/user5.png" alt="" /></a></div>
                    <div class="desc">
                      <h5><a href="">Lane Kitmari (@lane_kitmare)</a></h5>
                    </div>
                  </li>
                  <li class="new"><a href="">See All Users</a></li>
                </ul>
              </div>
            </div>
          </li>
          <li>
            <div class="btn-group">
              <button class="btn btn-default dropdown-toggle tp-icon" data-toggle="dropdown">
                <i class="glyphicon glyphicon-envelope"></i>
                <span class="badge">1</span>
              </button>
              <div class="dropdown-menu dropdown-menu-head pull-right">
                <h5 class="title">You Have 1 New Message</h5>
                <ul class="dropdown-list gen-list">
                  <li class="new">
                    <a href="">
                    <span class="thumb"><img src="images/photos/user1.png" alt="" /></span>
                    <span class="desc">
                      <span class="name">Draniem Daamul <span class="badge badge-success">new</span></span>
                      <span class="msg">Lorem ipsum dolor sit amet...</span>
                    </span>
                    </a>
                  </li>
                  <li>
                    <a href="">
                    <span class="thumb"><img src="images/photos/user2.png" alt="" /></span>
                    <span class="desc">
                      <span class="name">Nusja Nawancali</span>
                      <span class="msg">Lorem ipsum dolor sit amet...</span>
                    </span>
                    </a>
                  </li>
                  <li>
                    <a href="">
                    <span class="thumb"><img src="images/photos/user3.png" alt="" /></span>
                    <span class="desc">
                      <span class="name">Weno Carasbong</span>
                      <span class="msg">Lorem ipsum dolor sit amet...</span>
                    </span>
                    </a>
                  </li>
                  <li>
                    <a href="">
                    <span class="thumb"><img src="images/photos/user4.png" alt="" /></span>
                    <span class="desc">
                      <span class="name">Zaham Sindilmaca</span>
                      <span class="msg">Lorem ipsum dolor sit amet...</span>
                    </span>
                    </a>
                  </li>
                  <li>
                    <a href="">
                    <span class="thumb"><img src="images/photos/user5.png" alt="" /></span>
                    <span class="desc">
                      <span class="name">Veno Leongal</span>
                      <span class="msg">Lorem ipsum dolor sit amet...</span>
                    </span>
                    </a>
                  </li>
                  <li class="new"><a href="">Read All Messages</a></li>
                </ul>
              </div>
            </div>
          </li>
          <li>
            <div class="btn-group">
              <button class="btn btn-default dropdown-toggle tp-icon" data-toggle="dropdown">
                <i class="glyphicon glyphicon-globe"></i>
                <span class="badge">5</span>
              </button>
              <div class="dropdown-menu dropdown-menu-head pull-right">
                <h5 class="title">You Have 5 New Notifications</h5>
                <ul class="dropdown-list gen-list">
                  <li class="new">
                    <a href="">
                    <span class="thumb"><img src="images/photos/user4.png" alt="" /></span>
                    <span class="desc">
                      <span class="name">Zaham Sindilmaca <span class="badge badge-success">new</span></span>
                      <span class="msg">is now following you</span>
                    </span>
                    </a>
                  </li>
                  <li class="new">
                    <a href="">
                    <span class="thumb"><img src="images/photos/user5.png" alt="" /></span>
                    <span class="desc">
                      <span class="name">Weno Carasbong <span class="badge badge-success">new</span></span>
                      <span class="msg">is now following you</span>
                    </span>
                    </a>
                  </li>
                  <li class="new">
                    <a href="">
                    <span class="thumb"><img src="images/photos/user3.png" alt="" /></span>
                    <span class="desc">
                      <span class="name">Veno Leongal <span class="badge badge-success">new</span></span>
                      <span class="msg">likes your recent status</span>
                    </span>
                    </a>
                  </li>
                  <li class="new">
                    <a href="">
                    <span class="thumb"><img src="images/photos/user3.png" alt="" /></span>
                    <span class="desc">
                      <span class="name">Nusja Nawancali <span class="badge badge-success">new</span></span>
                      <span class="msg">downloaded your work</span>
                    </span>
                    </a>
                  </li>
                  <li class="new">
                    <a href="">
                    <span class="thumb"><img src="images/photos/user3.png" alt="" /></span>
                    <span class="desc">
                      <span class="name">Nusja Nawancali <span class="badge badge-success">new</span></span>
                      <span class="msg">send you 2 messages</span>
                    </span>
                    </a>
                  </li>
                  <li class="new"><a href="">See All Notifications</a></li>
                </ul>
              </div>
            </div>
          </li>
          <li>
            <div class="btn-group">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <img src="images/photos/loggeduser.png" alt="" />
                John Doe
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                <li><a href="profile.html"><i class="glyphicon glyphicon-user"></i> My Profile</a></li>
                <li><a href="#"><i class="glyphicon glyphicon-cog"></i> Account Settings</a></li>
                <li><a href="#"><i class="glyphicon glyphicon-question-sign"></i> Help</a></li>
                <li><a href="signin.html"><i class="glyphicon glyphicon-log-out"></i> Log Out</a></li>
              </ul>
            </div>
          </li>
          <li>
            <button id="chatview" class="btn btn-default tp-icon chat-icon">
                <i class="glyphicon glyphicon-comment"></i>
            </button>
          </li>
        </ul>
      </div><!-- header-right -->
      
    </div><!-- headerbar -->
        
    <div class="pageheader">
      <h2><i class="fa fa-pencil"></i> Form Layouts <span>Subtitle goes here...</span></h2>
      <div class="breadcrumb-wrapper">
        <span class="label">You are here:</span>
        <ol class="breadcrumb">
          <li><a href="index.html">News</a></li>
          <li><a href="general-forms.html">Forms</a></li>
          <li class="active">Form Layouts</li>
        </ol>
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
@else
    @yield('login')
@endif
</html>
