@extends('layouts.public')

@section('title', 'Tentang Kami')

@section('content')
    <section class="page-header">
        <div class="container text-center">
            <h1 class="fw-bold">Tentang Kami</h1>
            <p class="text-white-50">Mengenal lebih dekat layanan penyewaan mobil kami</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5">
                    <div class="car-detail-visual">
                        <div class="detail-car"><x-icon name="car" class="icon-car-placeholder" /></div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <span class="section-label">Siapa Kami</span>
                    <h2 class="section-title mb-3">Layanan Sewa Mobil Terpercaya</h2>
                    <p class="text-muted">
                        Kami adalah penyedia layanan penyewaan mobil yang berkomitmen memberikan
                        pengalaman perjalanan terbaik. Dengan armada yang terawat dan harga yang
                        transparan, kami melayani kebutuhan perjalanan pribadi maupun dinas.
                    </p>
                    <p class="text-muted">
                        Didukung oleh tim profesional, kami memastikan setiap mobil dalam kondisi
                        prima dan siap pakai. Kepuasan pelanggan adalah prioritas utama kami.
                    </p>
                    <div class="row g-3 mt-2">
                        <div class="col-6">
                            <div class="detail-spec">
                                <div class="spec-icon"><x-icon name="shield" /></div>
                                <small>Jaminan</small>
                                <div class="fw-bold">Mobil Terawat</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="detail-spec">
                                <div class="spec-icon"><x-icon name="wallet" /></div>
                                <small>Harga</small>
                                <div class="fw-bold">Transparan</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="detail-spec">
                                <div class="spec-icon"><x-icon name="heart" /></div>
                                <small>Layanan</small>
                                <div class="fw-bold">Pelanggan Prioritas</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="detail-spec">
                                <div class="spec-icon"><x-icon name="zap" /></div>
                                <small>Proses</small>
                                <div class="fw-bold">Cepat & Mudah</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-4">
                <span class="section-label">Angka Kami</span>
                <h2 class="section-title">Dipercaya Banyak Pelanggan</h2>
            </div>
            <div class="row g-4 text-center">
                <div class="col-6 col-lg-3">
                    <div class="step-card">
                        <div class="step-icon mx-auto"><x-icon name="car" /></div>
                        <h3 class="fw-bold text-primary">{{ $total_mobil }}</h3>
                        <p class="text-muted mb-0">Unit Mobil</p>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="step-card">
                        <div class="step-icon mx-auto"><x-icon name="users" /></div>
                        <h3 class="fw-bold text-primary">{{ $total_pengguna }}</h3>
                        <p class="text-muted mb-0">Pelanggan</p>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="step-card">
                        <div class="step-icon mx-auto"><x-icon name="clipboard" /></div>
                        <h3 class="fw-bold text-primary">{{ $total_transaksi }}</h3>
                        <p class="text-muted mb-0">Transaksi</p>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="step-card">
                        <div class="step-icon mx-auto"><x-icon name="star" /></div>
                        <h3 class="fw-bold text-primary">5.0</h3>
                        <p class="text-muted mb-0">Rating Layanan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="step-card h-100">
                        <div class="step-icon"><x-icon name="target" /></div>
                        <h5 class="fw-bold">Visi Kami</h5>
                        <p class="text-muted">
                            Menjadi penyedia layanan penyewaan mobil terdepan yang memberikan
                            solusi mobilitas mudah, nyaman, dan terjangkau bagi semua orang.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="step-card h-100">
                        <div class="step-icon"><x-icon name="route" /></div>
                        <h5 class="fw-bold">Misi Kami</h5>
                        <ul class="text-muted mb-0 ps-3">
                            <li class="mb-1">Menyediakan armada berkualitas dan terawat.</li>
                            <li class="mb-1">Memberikan pelayanan ramah dan profesional.</li>
                            <li class="mb-1">Menawarkan harga sewa yang transparan dan bersaing.</li>
                            <li>Terus berinovasi demi kenyamanan pelanggan.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pb-5">
        <div class="container">
            <div class="cta-box rounded-4 p-5 text-center">
                <h2 class="fw-bold mb-2">Mari Mulai Perjalanan Anda</h2>
                <p class="mb-4">Jelajahi armada kami dan temukan mobil yang tepat untuk Anda.</p>
                <a href="{{ url('sewa-mobil') }}" class="btn btn-light btn-lg px-5">Lihat Armada</a>
            </div>
        </div>
    </section>
@endsection
