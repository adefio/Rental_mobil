@extends('layouts.public')

@section('title', 'Sewa Mobil')
@section('meta_description', 'Jelajahi armada mobil rental kami. Pilih mobil sesuai kebutuhan perjalanan Anda dengan harga terbaik.')

@section('content')
    <section class="page-header">
        <div class="container text-center">
            <h1 class="fw-bold">Armada Mobil Kami</h1>
            <p class="text-white-50">Pilih mobil sesuai kebutuhan perjalanan Anda</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <form method="GET" action="{{ url('sewa-mobil') }}" class="mb-4">
                <div class="row justify-content-center g-2">
                    <div class="col-md-6 col-lg-4">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white"><x-icon name="search" /></span>
                            <input type="text" name="q" value="{{ request('q') }}"
                                class="form-control" placeholder="Cari mobil / merk / tahun...">
                        </div>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary btn-lg px-4">Cari</button>
                    </div>
                </div>
            </form>

            @if ($mobil->count())
                <div class="row g-4">
                    @foreach ($mobil as $m)
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="car-card h-100">
                                <div class="car-card-top">
                                    <div class="car-image">
                                        @if (!empty($m->gambar) && isset($m->gambar[0]))
                                            <img src="{{ gambar_url($m->gambar[0]) }}" alt="{{ $m->nama_mobil }}"
                                                class="car-image-img" width="400" height="160" loading="lazy" decoding="async">
                                        @else
                                            <img src="{{ gambar_url('hero/hero-fleet.png') }}"
                                                alt="{{ $m->nama_mobil }}" class="car-image-img" width="400" height="160" loading="lazy"
                                                decoding="async">
                                        @endif
                                    </div>
                                    <span class="car-status {{ $m->status }}">{{ ucfirst($m->status) }}</span>
                                </div>
                                <div class="car-card-body d-flex flex-column">
                                    <h2 class="car-name">{{ $m->nama_mobil }}</h2>
                                    <div class="car-meta">
                                        <span>{{ $m->merk }}</span>
                                        <span>{{ $m->tahun }}</span>
                                    </div>
                                    <p class="text-muted small flex-grow-1">{{ \Illuminate\Support\Str::limit($m->deskripsi, 80) }}</p>
                                    <div class="car-price">Rp {{ number_format($m->harga_sewa, 0, ',', '.') }}<span class="car-price-unit">/hari</span></div>
                                    <a href="{{ url('sewa-mobil/' . $m->id) }}" class="btn btn-primary w-100">
                                        {{ $m->status == 'tersedia' ? 'Sewa Sekarang' : 'Lihat Detail' }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <x-empty-state icon="search" title="Mobil tidak ditemukan"
                    description="Coba kata kunci lain atau kembali ke beranda.">
                    <a href="{{ url('sewa-mobil') }}" class="btn btn-outline-primary">Reset Pencarian</a>
                </x-empty-state>
            @endif
        </div>
    </section>
@endsection
