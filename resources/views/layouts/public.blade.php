<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Rental Mobil') }} - @yield('title', 'Beranda')</title>

    <link rel="preconnect" href="//fonts.bunny.net" crossorigin>
    <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700,800&display=swap" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="public-page">
    <a class="skip-link" href="#konten-utama">Lewati ke konten utama</a>
    <nav class="navbar navbar-expand-lg public-navbar sticky-top">
        <div class="container">
            <a class="navbar-brand public-brand" href="{{ url('/') }}">
                <span class="brand-icon"><x-icon name="car" /></span>
                <span class="brand-text">Rental<span class="text-primary">Mobil</span></span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#publicNavbar" aria-controls="publicNavbar" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="publicNavbar">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('landing') ? 'active' : '' }}" href="{{ url('/') }}">
                            Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('katalog', 'mobil.detail') ? 'active' : '' }}"
                            href="{{ url('sewa-mobil') }}">
                            Mobil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tentang') ? 'active' : '' }}"
                            href="{{ url('tentang-kami') }}">
                            Tentang Kami
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('kontak') ? 'active' : '' }}"
                            href="{{ url('kontak') }}">
                            Kontak
                        </a>
                    </li>
                    @auth
                        @unless (auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('pesanan.saya') ? 'active' : '' }}"
                                    href="{{ url('pesanan-saya') }}">
                                    Pesanan Saya
                                </a>
                            </li>
                        @endunless
                    @endauth
                </ul>

                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <a class="btn btn-outline-primary btn-sm me-2" href="{{ route('login') }}">Masuk</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary btn-sm" href="{{ route('register') }}">Daftar</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#"
                                role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="public-avatar">
                                    @if (auth()->user()->avatar_url)
                                        <img src="{{ auth()->user()->avatar_url }}" alt="Foto profil">
                                    @else
                                        {{ auth()->user()->avatar_initial }}
                                    @endif
                                </span>
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                @unless (auth()->user()->isAdmin())
                                    <a class="dropdown-item" href="{{ url('pesanan-saya') }}">Pesanan Saya</a>
                                    <a class="dropdown-item" href="{{ url('pengaturan-akun') }}">Pengaturan Akun</a>
                                @endunless
                                @if (auth()->user()->isAdmin())
                                    <a class="dropdown-item" href="{{ url('/home') }}">Panel Admin</a>
                                @endif
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#"
                                    onclick="event.preventDefault(); new bootstrap.Modal(document.getElementById('logoutModal')).show();">
                                    Keluar
                                </a>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main id="konten-utama">
        @if (Session::has('pesan'))
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('pesan') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if (Session::has('error'))
            <div class="container mt-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ Session::get('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="public-footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="public-brand mb-2">
                        <span class="brand-icon"><x-icon name="car" /></span>
                        <span class="brand-text text-white">Rental<span class="text-primary">Mobil</span></span>
                    </div>
                    <p class="text-white-50 small footer-tagline">
                        {{ settings('slogan') }}
                    </p>
                    <div class="d-flex gap-2">
                        <a href="#" class="footer-social" aria-label="Facebook"><x-icon name="facebook" /></a>
                        <a href="#" class="footer-social" aria-label="Instagram"><x-icon name="instagram" /></a>
                        <a href="#" class="footer-social" aria-label="Twitter"><x-icon name="twitter" /></a>
                        <a href="#" class="footer-social" aria-label="YouTube"><x-icon name="youtube" /></a>
                    </div>
                </div>
                <div class="col-6 col-lg-2">
                    <h6 class="text-white fw-bold">Navigasi</h6>
                    <ul class="list-unstyled footer-links mb-0">
                        <li><a href="{{ url('/') }}">Beranda</a></li>
                        <li><a href="{{ url('sewa-mobil') }}">Mobil</a></li>
                        <li><a href="{{ url('tentang-kami') }}">Tentang Kami</a></li>
                        <li><a href="{{ url('kontak') }}">Kontak</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-2">
                    <h6 class="text-white fw-bold">Bantuan</h6>
                    <ul class="list-unstyled footer-links mb-0">
                        <li><a href="{{ url('sewa-mobil') }}">Cara Sewa</a></li>
                        <li><a href="{{ route('register') }}">Daftar Akun</a></li>
                        <li><a href="{{ route('login') }}">Masuk</a></li>
                        <li><a href="{{ url('pesanan-saya') }}">Pesanan Saya</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h6 class="text-white fw-bold">Kontak</h6>
                    <ul class="list-unstyled text-white-50 small footer-contact mb-0">
                        <li class="mb-2"><span class="contact-icon"><x-icon name="phone" /></span> {{ settings('no_telepon') }}</li>
                        <li class="mb-2"><span class="contact-icon"><x-icon name="mail" /></span> {{ settings('email_kontak') }}</li>
                        <li class="mb-2"><span class="contact-icon"><x-icon name="map-pin" /></span> {{ settings('alamat') }}</li>
                    </ul>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="footer-bottom">
                <span class="small text-white-50">&copy; {{ date('Y') }} RentalMobil. Hak cipta dilindungi.</span>
                <span class="footer-bottom-links small">
                    <a href="#" class="text-white-50">Kebijakan Privasi</a>
                    <a href="#" class="text-white-50">Syarat &amp; Ketentuan</a>
                </span>
            </div>
        </div>
    </footer>

    <x-logout-modal />
</body>

</html>
