<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('') }}/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('') }}/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('') }}/img/favicon-16x16.png">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{env('APP_NAME')}} | @yield('title')</title>

    <!-- Scripts -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>
