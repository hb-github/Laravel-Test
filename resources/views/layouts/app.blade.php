<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Insurance Application Demo</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        @yield('add_css')
    </head>
    <body>
        @include('includes.header')
        <div class="container" id="appContainer">
            @yield('content')
        </div>

        <script src = "{{ asset('js/jquery-2.1.3.min.js') }}" type ="text/javascript"></script>
        <script src = "{{ asset('js/bootstrap.js') }}" type ="text/javascript"></script>
        <script src = "{{ asset('js/underscore-min.js') }}" type ="text/javascript"></script>
        <script src = "{{ asset('js/backbone-min.js') }}" type ="text/javascript"></script>
        @yield('add_js')
    </body>
</html>