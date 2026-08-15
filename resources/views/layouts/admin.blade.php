<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Dashboard')</title>

    <link rel="preconnect" href="//fonts.bunny.net" crossorigin>
    <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700&display=swap" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <a class="skip-link" href="#konten-admin">Lewati ke konten utama</a>
    <div class="admin-layout d-flex">
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-brand">
                <a href="{{ url('/home') }}" class="text-decoration-none d-flex align-items-center gap-2">
                    <span class="brand-icon"><x-icon name="car" /></span>
                    <span class="brand-text">Rental Mobil</span>
                </a>
                <button class="sidebar-close d-lg-none" id="sidebarClose" type="button" aria-label="Tutup menu">
                    <x-icon name="x" class="icon" />
                </button>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section-label">Menu Utama</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ url('/home') }}">
                            <i class="nav-icon"><x-icon name="dashboard" /></i> Dashboard
                        </a>
                    </li>
                </ul>

                <div class="nav-section-label">Data Rental</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('mobil*') ? 'active' : '' }}" href="{{ url('mobil') }}">
                            <i class="nav-icon"><x-icon name="car" /></i> Data Mobil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('pengguna*') ? 'active' : '' }}" href="{{ url('pengguna') }}">
                            <i class="nav-icon"><x-icon name="users" /></i> Data Pengguna
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('transaksi*') ? 'active' : '' }}" href="{{ url('transaksi') }}">
                            <i class="nav-icon"><x-icon name="clipboard" /></i> Data Transaksi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('pengembalian*') ? 'active' : '' }}" href="{{ url('pengembalian') }}">
                            <i class="nav-icon"><x-icon name="refresh" /></i> Data Pengembalian
                        </a>
                    </li>
                </ul>

                <div class="nav-section-label">Laporan</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('mobil/laporan/cetak') }}" target="_blank">
                            <i class="nav-icon"><x-icon name="file-text" /></i> Laporan Mobil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('pengguna/laporan/cetak') }}" target="_blank">
                            <i class="nav-icon"><x-icon name="file-text" /></i> Laporan Pengguna
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('transaksi/laporan/cetak') }}" target="_blank">
                            <i class="nav-icon"><x-icon name="file-text" /></i> Laporan Transaksi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('pengembalian/laporan/cetak') }}" target="_blank">
                            <i class="nav-icon"><x-icon name="file-text" /></i> Laporan Pengembalian
                        </a>
                    </li>
                </ul>

                <div class="nav-section-label">Lainnya</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('pesan*') ? 'active' : '' }}" href="{{ url('pesan') }}">
                            <i class="nav-icon"><x-icon name="message-circle" /></i> Pesan Masuk
                            @if (app(\App\Contracts\Repositories\PesanRepositoryInterface::class)->jumlahBelumDibaca() > 0)
                                <span class="badge bg-danger rounded-pill ms-auto">
                                    {{ app(\App\Contracts\Repositories\PesanRepositoryInterface::class)->jumlahBelumDibaca() }}
                                </span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('bantuan*') ? 'active' : '' }}" href="{{ url('bantuan') }}">
                            <i class="nav-icon"><x-icon name="book" /></i> Bantuan & Panduan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('pengaturan*') ? 'active' : '' }}" href="{{ url('pengaturan') }}">
                            <i class="nav-icon"><x-icon name="settings" /></i> Pengaturan Aplikasi
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="sidebar-footer">
                <a class="nav-link text-danger" href="#" role="button"
                    onclick="event.preventDefault(); new bootstrap.Modal(document.getElementById('logoutModal')).show();">
                    <i class="nav-icon"><x-icon name="log-out" /></i> Logout
                </a>
            </div>
        </aside>

        <div class="sidebar-backdrop" id="sidebarBackdrop" aria-hidden="true"></div>

        <div class="admin-main">
            <header class="admin-topbar">
                <button class="btn btn-link d-lg-none" id="sidebarToggle" type="button" aria-label="Buka menu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="topbar-title">
                    @yield('title', 'Dashboard')
                </div>
                <div class="ms-auto d-flex align-items-center gap-3">
                    <div class="dropdown topbar-user-dropdown">
                        <button class="topbar-user-link d-flex align-items-center gap-2 text-decoration-none border-0 bg-transparent"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false"
                            aria-label="Menu pengguna">
                            <div class="text-end d-none d-sm-block">
                                <div class="fw-semibold topbar-user">{{ Auth::user()->name }}</div>
                                <small class="text-muted">Administrator</small>
                            </div>
                            <div class="topbar-avatar">
                                @if (auth()->user()->avatar_url)
                                    <img src="{{ auth()->user()->avatar_url }}" alt="Foto profil">
                                @else
                                    {{ auth()->user()->avatar_initial }}
                                @endif
                            </div>
                        </button>

                        <div class="dropdown-menu dropdown-menu-end topbar-user-menu" aria-labelledby="userDropdown">
                            <div class="px-3 py-2 border-bottom topbar-user-menu-head">
                                <div class="fw-bold small">{{ Auth::user()->name }}</div>
                                <small class="text-muted">{{ Auth::user()->email }}</small>
                            </div>
                            <a class="dropdown-item d-flex align-items-center gap-2 {{ request()->routeIs('admin.profil*') ? 'active' : '' }}"
                                href="{{ url('profil') }}">
                                <x-icon name="user" class="icon-sm" /> Profil Saya
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item d-flex align-items-center gap-2 text-danger" href="#"
                                onclick="event.preventDefault(); new bootstrap.Modal(document.getElementById('logoutModal')).show();">
                                <x-icon name="log-out" class="icon-sm" /> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <main class="admin-content" id="konten-admin">
                @if (Session::has('pesan'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('pesan') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (Session::has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ Session::get('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <x-logout-modal />

    @stack('scripts')

    <script>
        const adminLayout = document.querySelector('.admin-layout');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');

        function closeSidebar() {
            adminLayout?.classList.remove('sidebar-open');
            sidebarBackdrop?.classList.remove('show');
        }

        function openSidebar() {
            adminLayout?.classList.add('sidebar-open');
            sidebarBackdrop?.classList.add('show');
        }

        document.getElementById('sidebarToggle')?.addEventListener('click', function () {
            adminLayout?.classList.contains('sidebar-open') ? closeSidebar() : openSidebar();
        });

        document.getElementById('sidebarClose')?.addEventListener('click', closeSidebar);

        sidebarBackdrop?.addEventListener('click', closeSidebar);

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') closeSidebar();
        });

        document.querySelectorAll('.admin-sidebar .nav-link').forEach(function (link) {
            link.addEventListener('click', function () {
                if (window.innerWidth < 992) closeSidebar();
            });
        });
    </script>
</body>

</html>
