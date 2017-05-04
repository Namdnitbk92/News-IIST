@extends('layouts.app')

@section('login')
<body class="signin" >
<section>
    <div class="signinpanel" style="font-size:17px;">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <form  class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                 {{ csrf_field() }}
                <h4 class="nomargin">Đăng nhập vào hệ thống</h4>
                <p class="mt5 mb20"></p>
            
                <input name="email" type="email" class="form-control uname {{ $errors->has('email') ? ' has-error' : '' }}" placeholder="Tài khoản" />
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
                <input type="password" name="password" class="form-control pword {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Mật khẩu" />
                <a href="{{url('/password/reset')}}"><small>Quên mật khẩu?</small></a>
                <a href="{{ url('/register') }}"><small>Đăng ký tài khoản mới ?</small></a>
                <button class="btn btn-success btn-block">Đăng nhập</button>
            </form>
        </div>
        
    </div><!-- row -->
</div><!-- signin -->
</section>
</body>
@endsection
