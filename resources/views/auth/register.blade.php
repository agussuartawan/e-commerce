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

    <title>CV. Murni Sejati | Register</title>

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
            <div class="container mt-4">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">{{ __('Pendaftaran') }}</div>

                            <div class="card-body">
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf

                                    <div class="row mb-3">
                                        <label for="email"
                                            class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                                        <div class="col">
                                            <input id="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email') }}" required autocomplete="email" autofocus>

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="name"
                                            class="col-md-4 col-form-label text-md-end">{{ __('Username') }}</label>

                                        <div class="col">
                                            <input id="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                value="{{ old('name') }}" required autocomplete="name" autofocus>

                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="password"
                                            class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                        <div class="col">
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" required autocomplete="new-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="password-confirm"
                                            class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                        <div class="col">
                                            <input id="password-confirm" type="password" class="form-control"
                                                name="password_confirmation" required autocomplete="new-password">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="fullname"
                                            class="col-md-4 col-form-label text-md-end">{{ __('Nama Lengkap') }}</label>

                                        <div class="col">
                                            <input id="fullname" type="text"
                                                class="form-control @error('fullname') is-invalid @enderror"
                                                name="fullname" value="{{ old('fullname') }}" required
                                                autocomplete="fullname">

                                            @error('fullname')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="address"
                                            class="col-md-4 col-form-label text-md-end">{{ __('Alamat') }}</label>

                                        <div class="col">
                                            <textarea name="address" id="address"
                                                class="form-control">{{ old('address') }}</textarea>
                                            @error('address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="phone"
                                            class="col-md-4 col-form-label text-md-end">{{ __('No Telp') }}</label>

                                        <div class="col">
                                            <input id="phone" type="text"
                                                class="form-control @error('phone') is-invalid @enderror" name="phone"
                                                value="{{ old('phone') }}" required autocomplete="phone">

                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-0">
                                        <div class="col offset-md-4">
                                            <button type="submit" class="btn btn-primary btn-block mb-2">
                                                {{ __('Daftar') }}
                                            </button>
                                            <p class="text-center">Sudah punya akun? <a
                                                    href="{{ route('login') }}">Login</a></p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
</body>

</html>
