@extends('layouts.app')
@section('content')
<div class="contentpanel">
      
      <div class="row">
        <div class="col-sm-3">
          <img src="images/photos/profile-1.png" class="thumbnail img-responsive" alt="">
          
          <div class="mb30"></div>
          
          <h5 class="subtitle">About</h5>
          <p class="mb30">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitat... <a href="">Show More</a></p>
          
          <h5 class="subtitle">Connect</h5>
          <ul class="profile-social-list">
            <li><i class="fa fa-twitter"></i> <a href="">twitter.com/eileensideways</a></li>
            <li><i class="fa fa-facebook"></i> <a href="">facebook.com/eileen</a></li>
            <li><i class="fa fa-youtube"></i> <a href="">youtube.com/eileen22</a></li>
            <li><i class="fa fa-linkedin"></i> <a href="">linkedin.com/4ever-eileen</a></li>
            <li><i class="fa fa-pinterest"></i> <a href="">pinterest.com/eileen</a></li>
            <li><i class="fa fa-instagram"></i> <a href="">instagram.com/eiside</a></li>
          </ul>
          
          <div class="mb30"></div>
          
          <h5 class="subtitle">Address</h5>
          <address>
            795 Folsom Ave, Suite 600<br>
            San Francisco, CA 94107<br>
            <abbr title="Phone">P:</abbr> (123) 456-7890
          </address>
          
        </div><!-- col-sm-3 -->
        <div class="col-sm-9">
          
          <div class="profile-header">
            <h2 class="profile-name">{{$user->name}}</h2>
            <div class="profile-location"><i class="fa fa-map-marker"></i> {{$user->address}}</div>
            <div class="profile-position"><i class="fa fa-briefcase"></i> Software Engineer at <a href="">SomeCompany, Inc.</a></div>
            
            <div class="mb20"></div>
            
            <button class="btn btn-success mr5"><i class="fa fa-user"></i> Follow</button>
            <button class="btn btn-white"><i class="fa fa-envelope-o"></i> Message</button>
          </div><!-- profile-header -->
          
          <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-justified nav-profile">
          <li class="active"><a href="#activities" data-toggle="tab"><strong>Activities</strong></a></li>
          <li><a href="#followers" data-toggle="tab"><strong>Followers</strong></a></li>
        </ul>
        
        <!-- Tab panes -->
        <div class="tab-content">
          <div class="tab-pane active" id="activities">
            <div class="activity-list">
              
            </div><!-- activity-list -->
            
            <button class="btn btn-white btn-block">Show More</button>

          </div>
          <div class="tab-pane" id="followers">
            
            <div class="follower-list">
              
              <div class="media">
                <a class="pull-left" href="#">
                </a>
                <div class="media-body">
                  <h3 class="follower-name">Ray Sin</h3>
                  <div class="profile-location"><i class="fa fa-map-marker"></i> San Francisco, California, USA</div>
                  <div class="profile-position"><i class="fa fa-briefcase"></i> Software Engineer at <a href="">SomeCompany, Inc.</a></div>
                  
                  <div class="mb20"></div>
                  
                  <button class="btn btn-sm btn-success mr5"><i class="fa fa-user"></i> Follow</button>
                  <button class="btn btn-sm btn-white"><i class="fa fa-envelope-o"></i> Message</button>
                </div>
              </div><!-- media -->
              
              <div class="media">
                <a class="pull-left" href="#">
                </a>
                <div class="media-body">
                  <h3 class="follower-name">Weno Carasbong</h3>
                  <div class="profile-location"><i class="fa fa-map-marker"></i> Cebu City, Philippines</div>
                  <div class="profile-position"><i class="fa fa-briefcase"></i> Software Engineer at <a href="">ITCompany, Inc.</a></div>
                  
                  <div class="mb20"></div>
                  
                  <button class="btn btn-sm btn-primary mr5"><i class="fa fa-check"></i> Following</button>
                  <button class="btn btn-sm btn-white"><i class="fa fa-envelope-o"></i> Message</button>
                </div>
              </div><!-- media -->
              
              <div class="media">
                <a class="pull-left" href="#">
                </a>
                <div class="media-body">
                  <h3 class="follower-name">Nusja Nawancali</h3>
                  <div class="profile-location"><i class="fa fa-map-marker"></i> Madrid, Spain</div>
                  <div class="profile-position"><i class="fa fa-briefcase"></i> CEO at <a href="">SomeCompany, Inc.</a></div>
                  
                  <div class="mb20"></div>
                  
                  <button class="btn btn-sm btn-success mr5"><i class="fa fa-user"></i> Follow</button>
                  <button class="btn btn-sm btn-white"><i class="fa fa-envelope-o"></i> Message</button>
                </div>
              </div><!-- media -->
              
              <div class="media">
                <a class="pull-left" href="#">
                </a>
                <div class="media-body">
                  <h3 class="follower-name">Zaham Sindilmaca</h3>
                  <div class="profile-location"><i class="fa fa-map-marker"></i> Bangkok, Thailand</div>
                  <div class="profile-position"><i class="fa fa-briefcase"></i> Java Developer at <a href="">ITCompany, Inc.</a></div>
                  
                  <div class="mb20"></div>
                  
                  <button class="btn btn-sm btn-primary mr5"><i class="fa fa-check"></i> Following</button>
                  <button class="btn btn-sm btn-white"><i class="fa fa-envelope-o"></i> Message</button>
                </div>
              </div><!-- media -->
              
              <div class="media">
                <a class="pull-left" href="#">
                </a>
                <div class="media-body">
                  <h3 class="follower-name">Christopher Atam</h3>
                  <div class="profile-location"><i class="fa fa-map-marker"></i> Tokyo, Japan</div>
                  <div class="profile-position"><i class="fa fa-briefcase"></i> QA Engineer at <a href="">SomeCompany, Inc.</a></div>
                  
                  <div class="mb20"></div>
                  
                  <button class="btn btn-sm btn-success mr5"><i class="fa fa-user"></i> Follow</button>
                  <button class="btn btn-sm btn-white"><i class="fa fa-envelope-o"></i> Message</button>
                </div>
              </div><!-- media -->
              
              <div class="media">
                <a class="pull-left" href="#">
                </a>
                <div class="media-body">
                  <h3 class="follower-name">Venro Leonga</h3>
                  <div class="profile-location"><i class="fa fa-map-marker"></i> Paris, France</div>
                  <div class="profile-position"><i class="fa fa-briefcase"></i> UX Designer at <a href="">ITCompany, Inc.</a></div>
                  
                  <div class="mb20"></div>
                  
                  <button class="btn btn-sm btn-success mr5"><i class="fa fa-user"></i> Follow</button>
                  <button class="btn btn-sm btn-white"><i class="fa fa-envelope-o"></i> Message</button>
                </div>
              </div><!-- media -->
              
            </div><!--follower-list -->
            
          </div>
        </div><!-- tab-content -->
          
        </div><!-- col-sm-9 -->
      </div><!-- row -->
      
    </div>
    @endsection