@extends('layouts.public')

@section('title', 'Pesanan Saya')

@section('content')
    <section class="page-header">
        <div class="container">
            <h1 class="fw-bold mb-0">Pesanan Saya</h1>
            <p class="text-white-50 mb-0">Kelola pemesanan mobil Anda</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            @if ($pesanan->count())
                <div class="row g-4">
                    @foreach ($pesanan as $t)
                        <div class="col-md-6 col-xl-4">
                            <div class="card pesanan-card shadow-sm h-100">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <small class="text-muted">No. Pesanan</small>
                                            <h5 class="fw-bold mb-0">#{{ str_pad($t->id, 4, '0', STR_PAD_LEFT) }}</h5>
                                        </div>
                                        <span class="badge rounded-pill
                                            {{ $t->status_pembayaran == 'lunas' ? 'bg-success' : ($t->status_pembayaran == 'selesai' ? 'bg-info text-dark' : ($t->status_pembayaran == 'pending' ? 'bg-warning text-dark' : 'bg-danger')) }}">
                                            {{ ucfirst($t->status_pembayaran) }}
                                        </span>
                                    </div>

                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <div class="pesanan-car-icon"><x-icon name="car" /></div>
                                        <div>
                                            <div class="fw-bold">{{ $t->mobil->nama_mobil ?? 'Mobil' }}</div>
                                            <small class="text-muted">{{ $t->mobil->merk ?? '' }} {{ $t->mobil->tahun ?? '' }}</small>
                                        </div>
                                    </div>

                                    <div class="pesanan-info">
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Mulai</span>
                                            <span class="fw-semibold">{{ \Carbon\Carbon::parse($t->tanggal_mulai)->format('d M Y') }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Selesai</span>
                                            <span class="fw-semibold">{{ \Carbon\Carbon::parse($t->tanggal_selesai)->format('d M Y') }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between border-top pt-2 mt-2">
                                            <span class="text-muted">Total</span>
                                            <span class="fw-bold fs-5">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</span>
                                        </div>
                                    </div>

                                    @if ($t->status_pembayaran == 'pending')
                                        <div class="alert alert-warning small py-2 mt-3 mb-2">
                                            Menunggu pembayaran. Lakukan transfer dan unggah bukti untuk dikonfirmasi admin.
                                        </div>

                                        @if ($t->bukti_pembayaran)
                                            <div class="alert alert-info small py-2 mb-2 d-flex align-items-center gap-2">
                                                <x-icon name="check-circle" class="icon-sm" /> Bukti pembayaran terkirim. Menunggu verifikasi admin.
                                            </div>
                                        @else
                                            <form action="{{ url('pesanan-saya/' . $t->id . '/konfirmasi') }}" method="POST"
                                                enctype="multipart/form-data" class="mb-2">
                                                @csrf
                                                <div class="input-group input-group-sm mb-2">
                                                    <input type="file" class="form-control" name="bukti_pembayaran"
                                                        accept="image/jpeg,image/png,image/jpg,image/webp"
                                                        aria-label="Unggah bukti pembayaran" required>
                                                </div>
                                                <small class="text-muted d-block mb-2">Format JPG, PNG, WEBP. Maks 5 MB.</small>
                                                <button type="submit" class="btn btn-primary w-100">
                                                    <x-icon name="upload" class="icon-sm" /> Konfirmasi Pembayaran
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ url('pesanan-saya/' . $t->id . '/batal') }}" method="POST"
                                            onsubmit="return confirm('Batalkan pemesanan ini?');">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger w-100">Batalkan Pesanan</button>
                                        </form>
                                    @elseif ($t->status_pembayaran == 'lunas')
                                        <div class="alert alert-success small py-2 mt-3 mb-0 d-flex align-items-center gap-2">
                                            <x-icon name="check-circle" class="icon-sm" /> Pembayaran lunas. Mobil siap diambil.
                                        </div>
                                    @elseif ($t->status_pembayaran == 'selesai')
                                        <div class="alert alert-info small py-2 mt-3 mb-0 d-flex align-items-center gap-2">
                                            <x-icon name="refresh" class="icon-sm" /> Transaksi selesai. Mobil sudah dikembalikan.
                                        </div>
                                    @else
                                        <div class="alert alert-danger small py-2 mt-3 mb-0">
                                            Pesanan ini telah dibatalkan.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <x-empty-state icon="inbox" title="Belum ada pesanan"
                    description="Anda belum memiliki pemesanan mobil.">
                    <a href="{{ url('sewa-mobil') }}" class="btn btn-primary">Sewa Mobil Sekarang</a>
                </x-empty-state>
            @endif
        </div>
    </section>
@endsection
