<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <style type="text/css">
        * {
            padding: 0;
            margin: 0;
        }

        body {
            font-family: sans-serif;
        }

        .container {
            margin: 0 auto;
            padding: 20px;
        }

        .table-heading {
            border-bottom: 3px solid #000;
            width: 100%;
        }

        .logo {
            width: 100px;
        }

        .heading {
            text-align: left;
            line-height: 18px;
            padding: 5px;
        }

        img {
            width: 110px;
        }

    </style>
    @stack('css')
</head>

<body>
    <div class="container">
        <table class="table-heading">
            <tr>
                <td class="logo">
                    <img src="{{ asset('img/logo.png') }}">
                </td>
                <td class="heading">
                    <h3>{{ env('APP_NAME') }}</h3>
                    <p>Jl. Raya Dalung Utara No. 99 ( belakang Gong Cafe ),</p>
                    <p>Abianbase, Badung - Bali, Dalung, Kuta Utara, Dalung,</p>
                    <p>Kec. Kuta Utara, Kabupaten Badung, Bali 80361</p>
                    <p>Telp : 0818-367-057</p>
                </td>
            </tr>
        </table>
    </div>

    @yield('content')
</body>

</html>
