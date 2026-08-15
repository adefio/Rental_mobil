@extends('layouts.public')

@section('title', $mobil->nama_mobil)

@section('content')
    <section class="page-header">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('sewa-mobil') }}" class="text-white-50 text-decoration-none">Sewa Mobil</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">{{ $mobil->nama_mobil }}</li>
                </ol>
            </nav>
            <h1 class="fw-bold mb-0">{{ $mobil->nama_mobil }}</h1>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-7">
                    <div class="car-detail-visual mb-4">
                        @if (!empty($mobil->gambar))
                            <img id="gambarUtama" src="{{ asset('storage/' . $mobil->gambar[0]) }}"
                                alt="{{ $mobil->nama_mobil }}" class="detail-car-img" fetchpriority="high">
                            @if (count($mobil->gambar) > 1)
                                <div class="detail-gallery d-flex gap-2 mt-3 flex-wrap justify-content-center">
                                    @foreach ($mobil->gambar as $i => $path)
                                        <button type="button" class="detail-thumb-btn {{ $i === 0 ? 'active' : '' }}"
                                            data-src="{{ asset('storage/' . $path) }}" aria-label="Lihat gambar {{ $i + 1 }}">
                                            <img src="{{ asset('storage/' . $path) }}" alt="Gambar {{ $i + 1 }}" loading="lazy">
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <img src="{{ asset('storage/hero/hero-fleet.png') }}" alt="{{ $mobil->nama_mobil }}"
                                class="detail-car-img" loading="lazy" decoding="async">
                        @endif
                    </div>

                    <h3 class="fw-bold mb-3">Deskripsi</h3>
                    <p class="text-muted">{{ $mobil->deskripsi ?: 'Belum ada deskripsi untuk mobil ini.' }}</p>

                    <div class="row g-3 mt-2">
                        <div class="col-sm-6 col-lg-3">
                            <div class="detail-spec">
                                <div class="spec-icon"><x-icon name="car" /></div>
                                <small>Merk</small>
                                <strong>{{ $mobil->merk }}</strong>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="detail-spec">
                                <div class="spec-icon"><x-icon name="calendar" /></div>
                                <small>Tahun</small>
                                <strong>{{ $mobil->tahun }}</strong>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="detail-spec">
                                <div class="spec-icon"><x-icon name="wallet" /></div>
                                <small>Harga</small>
                                <strong>Rp {{ number_format($mobil->harga_sewa, 0, ',', '.') }}/hari</strong>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="detail-spec">
                                <div class="spec-icon"><x-icon name="info" /></div>
                                <small>Status</small>
                                <strong class="text-{{ $mobil->status == 'tersedia' ? 'success' : 'warning' }}">
                                    {{ ucfirst($mobil->status) }}
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card booking-card shadow-sm">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-1">Pesan Mobil Ini</h4>
                            <div class="booking-price mb-3">
                                Rp {{ number_format($mobil->harga_sewa, 0, ',', '.') }}
                                <small class="text-muted">/hari</small>
                            </div>

                            @auth
                                @if ($mobil->status == 'tersedia')
                                    <form action="{{ url('sewa-mobil/' . $mobil->id . '/booking') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Tanggal Mulai</label>
                                            <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                                                class="form-control" min="{{ date('Y-m-d') }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Tanggal Selesai</label>
                                            <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                                                class="form-control" min="{{ date('Y-m-d') }}" required>
                                        </div>

                                        <div class="alert alert-info small py-2">
                                            <div class="d-flex justify-content-between">
                                                <span>Durasi</span>
                                                <strong id="durasiText">0 hari</strong>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span>Tarif</span>
                                                <span>Rp {{ number_format($mobil->harga_sewa, 0, ',', '.') }}/hari</span>
                                            </div>
                                            <hr class="my-1">
                                            <div class="d-flex justify-content-between fw-bold">
                                                <span>Perkiraan Total</span>
                                                <span id="totalText">Rp 0</span>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-lg w-100">
                                            Pesan Sekarang
                                        </button>
                                    </form>
                                @else
                                    <div class="alert alert-warning">
                                        Mobil ini sedang <strong>{{ $mobil->status }}</strong> dan tidak dapat dipesan saat ini.
                                    </div>
                                    <a href="{{ url('sewa-mobil') }}" class="btn btn-outline-primary w-100">
                                        Lihat Mobil Lain
                                    </a>
                                @endif
                            @else
                                <p class="text-muted">Masuk atau daftar untuk melakukan pemesanan.</p>
                                <a href="{{ route('login') }}" class="btn btn-primary w-100 mb-2">Masuk</a>
                                <a href="{{ route('register') }}" class="btn btn-outline-primary w-100">Daftar Akun</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        const harga = @json((float) $mobil->harga_sewa);
        const mul = document.getElementById('tanggal_mulai');
        const sel = document.getElementById('tanggal_selesai');
        const durasiText = document.getElementById('durasiText');
        const totalText = document.getElementById('totalText');

        if (mul && sel && durasiText && totalText) {
            const fmt = (n) => 'Rp ' + new Intl.NumberFormat('id-ID').format(n);

            function hitung() {
                if (!mul.value || !sel.value) return;
                const a = new Date(mul.value);
                const b = new Date(sel.value);
                if (b < a) {
                    sel.value = mul.value;
                }
                const days = Math.round((b - a) / 86400000) + 1;
                durasiText.textContent = days + ' hari';
                totalText.textContent = fmt(days * harga);
            }

            mul.addEventListener('change', function () {
                sel.min = mul.value;
                if (!sel.value) sel.value = mul.value;
                hitung();
            });
            sel.addEventListener('change', hitung);
        }

        document.querySelectorAll('.detail-thumb-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const gambarUtama = document.getElementById('gambarUtama');
                if (!gambarUtama) return;
                gambarUtama.src = this.dataset.src;
                document.querySelectorAll('.detail-thumb-btn').forEach(function (b) {
                    b.classList.remove('active');
                });
                this.classList.add('active');
            });
        });
    </script>
@endsection
