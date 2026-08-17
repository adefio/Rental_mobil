<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Rental Mobil') }} - @yield('title', 'Akun')</title>

    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700,800&display=swap" rel="stylesheet" media="print" onload="this.media='all'">

    @vite(['resources/sass/app.scss', 'resources/js/public.js'])
</head>

<body class="auth-page">
    <div class="auth-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5 col-lg-4">
                    <div class="text-center mb-4">
                        <a href="{{ url('/') }}" class="auth-brand">
                            <span class="brand-icon"><x-icon name="car" /></span>
                            <span class="brand-text">{{ settings('nama_aplikasi') }}</span>
                        </a>
                    </div>

                    <div class="card auth-card shadow-sm">
                        <div class="card-body p-4">
                            @yield('content')
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <a href="{{ url('/') }}" class="text-muted text-decoration-none small">← Kembali ke Beranda</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
