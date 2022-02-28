<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CV. Murni Sejati | Login</title>

    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('') }}/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('') }}/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('') }}/img/favicon-16x16.png">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('') }}/dist/css/adminlte.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('') }}/plugins/fontawesome-free/css/all.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                Identitas tersebut tidak terdaftar!
            </div>
        @endif
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <div class="text-center">
                    <img src="{{ asset('img/logo.png') }}" class="rounded" alt="..." width="128px"
                        height="128px">
                </div>
                <a href="{{ route('beranda') }}" class="h1">CV. Murni Sejati</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Selamat datang, silahkan login</p>

                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" name="email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" name="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    <h6 class="mt-2">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></h6>
                    <h6>Lupa password? <a href="{{ url('/password/reset') }}">Reset disini</a></h6>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('') }}/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('') }}/dist/js/adminlte.min.js"></script>
</body>

</html>
