@extends('layouts.general')
@section('title', 'Login')
@section('content')
    @push('css')
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    @endpush

    <div class="container">
        <div class="login-box mt-4 justify-content-center d-flex">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <div class="text-center">
                    <img src="{{ asset('img/null-avatar.png') }}" class="rounded" alt="...">
                    </div>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            Identitas tersebut tidak terdaftar!
                        </div>
                    @endif
                    <p class="login-box-msg text-center">Selamat datang, silahkan login</p>
                    <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" autofocus>
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
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </form>  
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    @endpush
@endsection
