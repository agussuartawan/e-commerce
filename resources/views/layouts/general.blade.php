<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
        <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        @stack('css')
        <title>@yield('title')</title>
      </head>
      <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">CV. Murni Sejati</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
            
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item {{ request()->is('beranda') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('beranda') }}">Beranda</a> 
                        </li>
                        @guest
                            <li class="nav-item {{ request()->is('login') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('panel.login') }}">Login</a>
                            </li>

                            <li class="nav-item {{ request()->is('register') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('register') }}">Daftar</a>
                            </li>
                        @else
                            @can('akses beranda')
                                <li class="nav-item {{ request()->is('payment') ? 'active' : '' }}">
                                    <a class="nav-link" href="#">Pembayaran</a>
                                </li>

                                <li class="nav-item {{ request()->is('delivery') ? 'active' : '' }}">
                                    <a class="nav-link" href="#">Pengiriman</a>
                                </li>
                            @endcan
                        @endguest

                    </ul>  
                    @auth
                        @can('akses beranda')
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
            
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                        @endcan
                    @endauth
                </div>
            </div>
        </nav>

        @yield('content')
        
        <script src="/plugins/jquery/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        @stack('js')
      </body>
</html>
