@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="admin-page-header d-flex flex-wrap align-items-end justify-content-between gap-3">
        <div>
            <h1 class="admin-page-title mb-1">
                Selamat datang, {{ auth()->user()->name }}
            </h1>
            <p class="admin-page-sub mb-0">
                Ringkasan aktivitas rental mobil Anda pada
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}.
            </p>
        </div>
    </div>

    <div class="mb-4">
        <div data-vue="DashboardStats"
            data-stats='@json($stats)'></div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="card page-card">
                <div class="card-header d-flex align-items-center gap-2">
                    <span class="card-header-icon"><x-icon name="wallet" class="icon" /></span>
                    Perkembangan Pendapatan
                    <span class="text-muted small fw-normal">dari transaksi lunas</span>
                </div>
                <div class="card-body">
                    <div data-vue="RevenueChart"
                        data-series='@json($pendapatan_series)'></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-1">
        <div class="col-lg-7">
            <div class="card page-card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <span>Transaksi Terbaru</span>
                    <a href="{{ url('transaksi') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Pengguna</th>
                                    <th>Mobil</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transaksi_terbaru as $t)
                                    <tr>
                                        <td>{{ $t->pengguna->nama ?? '-' }}</td>
                                        <td>{{ $t->mobil->nama_mobil ?? '-' }}</td>
                                        <td>Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($t->status_pembayaran == 'lunas')
                                                <span class="badge bg-success badge-status">Lunas</span>
                                            @elseif ($t->status_pembayaran == 'pending')
                                                <span class="badge bg-warning text-dark badge-status">Pending</span>
                                            @else
                                                <span class="badge bg-danger badge-status">Batal</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">Belum ada transaksi</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card page-card h-100">
                <div class="card-header">Mobil Terpopuler</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @forelse ($mobil_populer as $m)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <div class="fw-semibold">{{ $m->nama_mobil }}</div>
                                    <small class="text-muted">{{ $m->merk }} ({{ $m->tahun }})</small>
                                </div>
                                <span class="badge bg-primary rounded-pill">{{ $m->transaksi_count }} sewa</span>
                            </li>
                        @empty
                            <li class="list-group-item px-0 text-muted">Belum ada data</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
