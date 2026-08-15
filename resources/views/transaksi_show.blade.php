@extends('layouts.admin')

@section('title', 'Detail Transaksi')

@section('content')
    <div class="admin-page-header d-flex flex-wrap align-items-end justify-content-between gap-3">
        <div>
            <h1 class="admin-page-title mb-1">Detail Transaksi #{{ str_pad($transaksi->id, 4, '0', STR_PAD_LEFT) }}</h1>
            <p class="admin-page-sub mb-0">Ringkasan pesanan penyewaan mobil.</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ url('transaksi') }}" class="btn btn-light d-inline-flex align-items-center gap-2">
                <x-icon name="arrow-left" class="icon-sm" /> Kembali
            </a>
            @if ($transaksi->status_pembayaran !== 'batal' && $transaksi->status_pembayaran !== 'selesai')
                <a href="{{ url('transaksi/' . $transaksi->id . '/edit') }}"
                    class="btn btn-primary d-inline-flex align-items-center gap-2">
                    <x-icon name="edit" class="icon-sm" /> Edit
                </a>
            @endif
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card page-card mb-4">
                <div class="card-header d-flex align-items-center gap-2">
                    <span class="profile-section-icon"><x-icon name="car" class="icon-sm" /></span>
                    <span>Data Mobil</span>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        @if (!empty($transaksi->mobil->gambar) && isset($transaksi->mobil->gambar[0]))
                            <img src="{{ asset('storage/' . $transaksi->mobil->gambar[0]) }}" alt="Gambar mobil"
                                class="detail-mobil-thumb" loading="lazy" decoding="async">
                        @else
                            <div class="detail-mobil-thumb d-flex align-items-center justify-content-center bg-light">
                                <x-icon name="car" />
                            </div>
                        @endif
                        <div>
                            <div class="fw-bold fs-5">{{ $transaksi->mobil->nama_mobil ?? '-' }}</div>
                            <small class="text-muted">{{ $transaksi->mobil->merk ?? '' }} ({{ $transaksi->mobil->tahun ?? '' }})</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card page-card mb-4">
                <div class="card-header d-flex align-items-center gap-2">
                    <span class="profile-section-icon"><x-icon name="user" class="icon-sm" /></span>
                    <span>Data Pelanggan</span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <small class="text-muted">Nama</small>
                            <div class="fw-semibold">{{ $transaksi->pengguna->nama ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Email</small>
                            <div class="fw-semibold">{{ $transaksi->pengguna->email ?? '-' }}</div>
                        </div>
                        @if (!empty($transaksi->pengguna->no_telepon))
                            <div class="col-md-6">
                                <small class="text-muted">No. Telepon</small>
                                <div class="fw-semibold">{{ $transaksi->pengguna->no_telepon }}</div>
                            </div>
                        @endif
                        @if (!empty($transaksi->pengguna->alamat))
                            <div class="col-md-6">
                                <small class="text-muted">Alamat</small>
                                <div class="fw-semibold">{{ $transaksi->pengguna->alamat }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if ($transaksi->maintenance)
                <div class="card page-card mb-4">
                    <div class="card-header d-flex align-items-center gap-2">
                        <span class="profile-section-icon"><x-icon name="refresh" class="icon-sm" /></span>
                        <span>Data Pengembalian</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <small class="text-muted">Tanggal Kembali</small>
                                <div class="fw-semibold">{{ \Carbon\Carbon::parse($transaksi->maintenance->tanggal_pengembalian)->format('d M Y') }}</div>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">Denda Telat</small>
                                <div class="fw-semibold">Rp {{ number_format($transaksi->maintenance->denda_telat ?? 0, 0, ',', '.') }}</div>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">Biaya Kerusakan</small>
                                <div class="fw-semibold">Rp {{ number_format($transaksi->maintenance->biaya_kerusakan ?? 0, 0, ',', '.') }}</div>
                            </div>
                            @if (!empty($transaksi->maintenance->deskripsi_kerusakan))
                                <div class="col-12">
                                    <small class="text-muted">Deskripsi Kerusakan</small>
                                    <div class="fw-semibold">{{ $transaksi->maintenance->deskripsi_kerusakan }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @if ($transaksi->bukti_pembayaran)
                <div class="card page-card mb-4">
                    <div class="card-header d-flex align-items-center gap-2">
                        <span class="profile-section-icon"><x-icon name="wallet" class="icon-sm" /></span>
                        <span>Bukti Pembayaran</span>
                    </div>
                    <div class="card-body p-4">
                        <a href="{{ asset('storage/' . $transaksi->bukti_pembayaran) }}" target="_blank"
                            rel="noopener" class="d-inline-block">
                            <img src="{{ asset('storage/' . $transaksi->bukti_pembayaran) }}" alt="Bukti pembayaran"
                                class="bukti-thumb" loading="lazy" decoding="async">
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card page-card mb-4">
                <div class="card-header d-flex align-items-center gap-2">
                    <span class="profile-section-icon"><x-icon name="clipboard" class="icon-sm" /></span>
                    <span>Status Pesanan</span>
                </div>
                <div class="card-body p-4">
                    @if ($transaksi->status_pembayaran == 'lunas')
                        <span class="badge bg-success badge-status mb-3">Lunas</span>
                    @elseif ($transaksi->status_pembayaran == 'selesai')
                        <span class="badge bg-info text-dark badge-status mb-3">Selesai</span>
                    @elseif ($transaksi->status_pembayaran == 'pending')
                        <span class="badge bg-warning text-dark badge-status mb-3">Pending</span>
                    @else
                        <span class="badge bg-danger badge-status mb-3">Batal</span>
                    @endif

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Tanggal Pemesanan</span>
                        <span class="fw-semibold">{{ \Carbon\Carbon::parse($transaksi->tanggal_pemesanan)->format('d M Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Tanggal Mulai</span>
                        <span class="fw-semibold">{{ \Carbon\Carbon::parse($transaksi->tanggal_mulai)->format('d M Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Tanggal Selesai</span>
                        <span class="fw-semibold">{{ \Carbon\Carbon::parse($transaksi->tanggal_selesai)->format('d M Y') }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Total Harga</span>
                        <span class="fw-bold fs-5">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                    </div>

                    @if ($transaksi->status_pembayaran == 'pending')
                        <hr>
                        <form action="{{ url('transaksi/' . $transaksi->id . '/konfirmasi-bayar') }}" method="POST"
                            onsubmit="return confirm('Konfirmasi pembayaran transaksi ini?');">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">
                                <x-icon name="check-circle" class="icon-sm" /> Konfirmasi Pembayaran
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
