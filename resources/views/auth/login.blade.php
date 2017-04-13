@extends('layouts.app')

@section('login')
<body class="signin" >
<section>
    <div class="signinpanel">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <form  class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                 {{ csrf_field() }}
                <h4 class="nomargin">Sign In</h4>
                <p class="mt5 mb20">Login to access your account.</p>
            
                <input name="email" type="email" class="form-control uname {{ $errors->has('email') ? ' has-error' : '' }}" placeholder="Username" />
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
                <input type="password" name="password" class="form-control pword {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Password" />
                <a href="{{ url('/password/reset') }}"><small>Forgot Your Password?</small></a>
                <button class="btn btn-success btn-block">Sign In</button>
            </form>
        </div>
        
    </div><!-- row -->
</div><!-- signin -->
</section>
</body>
@endsection
