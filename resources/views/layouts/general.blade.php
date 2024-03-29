<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('') }}/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('') }}/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('') }}/img/favicon-16x16.png">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">



    <link rel="stylesheet" href="{{ asset('') }}/plugins/fontawesome-free/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    @stack('css')
    <title>{{ env('APP_NAME') }} | @yield('title')</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">{{ env('APP_NAME') }}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item {{ request()->is('beranda') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('beranda') }}">Beranda</a>
                    </li>
                    @guest
                        <li class="nav-item {{ request()->is('login') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>

                        <li class="nav-item {{ request()->is('register') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('register') }}">Daftar</a>
                        </li>
                    @else
                        @can('akses beranda')
                            <li class="nav-item {{ request()->is('payment*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('payment.index') }}">Pembayaran</a>
                            </li>

                            <li class="nav-item {{ request()->is('delivery*') || request()->is('order*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('delivery.index') }}">Pesanan</a>
                            </li>
                        @endcan
                    @endguest

                </ul>
                @auth
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @can('akses dashboard')
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                                        {{ __('Dashboard') }}
                                    </a>
                                @endcan
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                @endauth
            </div>
        </div>
    </nav>

    @yield('content')

    <script src="{{ asset('') }}/plugins/jquery/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    @stack('js')
</body>

</html>
