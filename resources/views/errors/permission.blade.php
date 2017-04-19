<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="images/favicon.png" type="image/png">

  <title>You dont have permission</title>

  <link rel="stylesheet" href="{{ asset('css/libs.css') }}">
    <!-- Scripts -->
  <script src="{{ asset('js/libs.js') }}"></script>

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
  <![endif]-->
</head>

<body class="notfound">

<section>
  
  <div class="notfoundpanel">
    <h1>Notice!</h1>
    <h3>The page you are looking for required permission!Seems to be you're not have permission to see this pages,Sorry.</h3>
     <a class="btn btn-success" href="{{route('back')}}"><i class="fa fa-chevron-left"></i>&nbsp; Back</a>
  </div><!-- notfoundpanel -->
  
</section>

</body>

</html>