@extends('layouts.public')

@section('title', 'Beranda')
@section('meta_description', 'Sewa mobil mudah, aman, dan terpercaya. Pilih armada terbaik dengan harga transparan dan proses pemesanan cepat.')

@section('content')
    <section class="public-hero">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="hero-badge"><x-icon name="badge-check" class="icon-sm" /> Penyewaan Mobil Terpercaya</span>
                    <h1 class="hero-title">
                        Sewa Mobil <span class="text-primary">Mudah</span>,<br>Aman, & Terpercaya
                    </h1>
                    <p class="hero-subtitle">
                        Pilih mobil favorit Anda dari armada kami dan nikmati perjalanan yang nyaman.
                        Proses pemesanan cepat, harga transparan, dan layanan terbaik untuk Anda.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ url('sewa-mobil') }}" class="btn btn-primary btn-lg px-4">
                            Lihat Armada Kami →
                        </a>
                        <a href="#cara-kerja" class="btn btn-outline-primary btn-lg px-4">Cara Kerja</a>
                    </div>
                    <div class="hero-stats d-flex gap-4 mt-4">
                        <div>
                            <div class="hero-stat-value">{{ $total_mobil }}</div>
                            <div class="hero-stat-label">Unit Mobil</div>
                        </div>
                        <div>
                            <div class="hero-stat-value">{{ $total_pengguna }}+</div>
                            <div class="hero-stat-label">Pelanggan</div>
                        </div>
                        <div>
                            <div class="hero-stat-value">{{ $total_transaksi }}+</div>
                            <div class="hero-stat-label">Transaksi</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-visual">
                        <div class="hero-car">
                            <img src="{{ gambar_url('hero/hero-fleet.png') }}"
                                alt="Barisan unit mobil rental" class="hero-fleet-img"
                                width="600" height="400" fetchpriority="high" decoding="async">
                        </div>
                        <div class="hero-card hero-card-1">
                            <div class="hero-card-icon"><x-icon name="check-circle" /></div>
                            <div>
                                <div class="fw-bold">Siap Pakai</div>
                                <small>Kondisi mobil terawat</small>
                            </div>
                        </div>
                        <div class="hero-card hero-card-2">
                            <div class="hero-card-icon"><x-icon name="wallet" /></div>
                            <div>
                                <div class="fw-bold">Harga Terjangkau</div>
                                <small>Mulai dari harga terbaik</small>
                            </div>
                        </div>
                        <div class="hero-card hero-card-3">
                            <div class="hero-card-icon"><x-icon name="shield" /></div>
                            <div>
                                <div class="fw-bold">Aman & Terpercaya</div>
                                <small>Legalitas lengkap</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="armada-band">
        <div class="container">
            <div class="text-center mb-4">
                <span class="section-label">Armada Lengkap</span>
                <h2 class="section-title">Barisan Unit Mobil Kami</h2>
                <p class="text-muted mb-0">Seluruh unit dalam satu barisan, siap melayani perjalanan Anda.</p>
            </div>
            <img src="{{ gambar_url('hero/armada-banner.png') }}" alt="Barisan unit mobil rental"
                class="armada-banner-img" width="1200" height="400" loading="lazy" decoding="async">
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="text-center mb-4">
                <span class="section-label">Armada Kami</span>
                <h2 class="section-title">Mobil Unggulan</h2>
                <p class="text-muted">Pilihan mobil yang paling banyak disewa pelanggan kami.</p>
            </div>

            @if ($mobil_populer->count())
                <div class="row g-4">
                    @foreach ($mobil_populer as $m)
                        <div class="col-sm-6 col-lg-3">
                            <div class="car-card h-100">
                                <div class="car-card-top">
                                    <div class="car-image">
                                        @if (!empty($m->gambar) && isset($m->gambar[0]))
                                            <img src="{{ gambar_url($m->gambar[0]) }}" alt="{{ $m->nama_mobil }}"
                                                class="car-image-img" width="400" height="160" loading="lazy" decoding="async">
                                        @else
                                            <div class="car-image-placeholder"><x-icon name="car" /></div>
                                        @endif
                                    </div>
                                    <span class="car-status {{ $m->status }}">{{ ucfirst($m->status) }}</span>
                                </div>
                                <div class="car-card-body d-flex flex-column flex-grow-1">
                                    <h3 class="car-name">{{ $m->nama_mobil }}</h3>
                                    <div class="car-meta flex-grow-1">
                                        <span>{{ $m->merk }}</span>
                                        <span>{{ $m->tahun }}</span>
                                        <span>{{ $m->transaksi_count }}× disewa</span>
                                    </div>
                                    <div class="car-price">Rp {{ number_format($m->harga_sewa, 0, ',', '.') }}<span class="car-price-unit">/hari</span></div>
                                    <a href="{{ url('sewa-mobil/' . $m->id) }}" class="btn btn-primary w-100">Sewa Sekarang</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <x-empty-state icon="car" title="Belum ada armada mobil"
                    description="Cek kembali nanti untuk melihat armada kami." />
            @endif
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="text-center mb-4">
                <span class="section-label">Armada Terbaru</span>
                <h2 class="section-title">Unit Baru di Armada Kami</h2>
                <p class="text-muted">Mobil terbaru yang baru bergabung dan siap disewa.</p>
            </div>

            @if ($mobil_baru->count())
                <div class="row g-4">
                    @foreach ($mobil_baru as $m)
                        <div class="col-sm-6 col-lg-3">
                            <div class="car-card h-100">
                                <div class="car-card-top">
                                    <div class="car-image">
                                        @if (!empty($m->gambar) && isset($m->gambar[0]))
                                            <img src="{{ gambar_url($m->gambar[0]) }}" alt="{{ $m->nama_mobil }}"
                                                class="car-image-img" width="400" height="160" loading="lazy" decoding="async">
                                        @else
                                            <div class="car-image-placeholder"><x-icon name="car" /></div>
                                        @endif
                                    </div>
                                    <span class="car-status {{ $m->status }}">{{ ucfirst($m->status) }}</span>
                                </div>
                                <div class="car-card-body d-flex flex-column flex-grow-1">
                                    <h3 class="car-name">{{ $m->nama_mobil }}</h3>
                                    <div class="car-meta flex-grow-1">
                                        <span>{{ $m->merk }}</span>
                                        <span>{{ $m->tahun }}</span>
                                        <span>{{ $m->transaksi_count }}× disewa</span>
                                    </div>
                                    <div class="car-price">Rp {{ number_format($m->harga_sewa, 0, ',', '.') }}<span class="car-price-unit">/hari</span></div>
                                    <a href="{{ url('sewa-mobil/' . $m->id) }}" class="btn btn-primary w-100">Sewa Sekarang</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <x-empty-state icon="car" title="Belum ada armada mobil"
                    description="Cek kembali nanti untuk melihat armada kami." />
            @endif
        </div>
    </section>

    <section class="py-5 bg-light" id="cara-kerja">
        <div class="container">
            <div class="text-center mb-4">
                <span class="section-label">Cara Kerja</span>
                <h2 class="section-title">Tiga Langkah Mudah</h2>
                <p class="text-muted">Sewa mobil dalam hitungan menit.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="step-card text-center">
                        <div class="step-number">1</div>
                        <div class="step-icon"><x-icon name="search" /></div>
                        <h3>Pilih Mobil</h3>
                        <p class="text-muted small">Jelajahi katalog dan pilih mobil yang sesuai kebutuhan Anda.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card text-center">
                        <div class="step-number">2</div>
                        <div class="step-icon"><x-icon name="calendar" /></div>
                        <h3>Tentukan Jadwal</h3>
                        <p class="text-muted small">Pilih tanggal mulai dan selesai peminjaman.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card text-center">
                        <div class="step-number">3</div>
                        <div class="step-icon"><x-icon name="key" /></div>
                        <h3>Ambil Mobil</h3>
                        <p class="text-muted small">Bayar di tempat dan kunci mobil siap diambil.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="cta-box rounded-4 p-5 text-center">
                <h2 class="fw-bold mb-2">Siap Menyewa Mobil?</h2>
                <p class="mb-4">Lihat armada mobil kami sekarang dan pilih yang paling cocok untuk Anda.</p>
                <a href="{{ url('sewa-mobil') }}" class="btn btn-light btn-lg px-5">Jelajahi Armada</a>
            </div>
        </div>
    </section>
@endsection
