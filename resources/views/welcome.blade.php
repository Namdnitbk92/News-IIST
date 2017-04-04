<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>News-IIST</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
        <script src="{{ elixir('js/app.js') }}"></script>
        <script src="{{ elixir('js/libs.js') }}"></script>
        <script src="{{ elixir('js/custom.js') }}"></script>
    </head>
    <body class="nav-md">
            <div id="app"></div>
        @include('index')
    </body>
</html>
