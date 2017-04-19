<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="images/favicon.png" type="image/png">

  <title>404</title>

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
    <h1>404!</h1>
    <h3>The page you are looking for has not been found!</h3>
    <h4>The page you are looking for might have been removed, had its name changed, or unavailable. <br />Maybe you could try a search:</h4>
    <form action="search-results.html">
        <input type="text" class="form-control" placeholder="Search for page" /> <button class="btn btn-success">Search</button>
    </form>
  </div><!-- notfoundpanel -->
  
</section>

</body>

</html>