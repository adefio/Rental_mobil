@extends('layouts.report')

@section('report-content')
    @php
        $totalSemua = $transaksi->sum('total_harga');
        $totalLunas = $transaksi->where('status_pembayaran', 'lunas')->sum('total_harga');
    @endphp

    <div class="report-info-bar">
        <span class="report-info-item">
            <x-icon name="clipboard" class="icon-sm" />
            Total Transaksi: <strong>{{ count($transaksi) }}</strong>
        </span>
        <span class="report-info-item">
            <x-icon name="check-circle" class="icon-sm" />
            Lunas: <strong>{{ $transaksi->where('status_pembayaran', 'lunas')->count() }}</strong>
        </span>
        <span class="report-info-item">
            <x-icon name="clock" class="icon-sm" />
            Pending: <strong>{{ $transaksi->where('status_pembayaran', 'pending')->count() }}</strong>
        </span>
        <span class="report-info-item">
            <x-icon name="x" class="icon-sm" />
            Batal: <strong>{{ $transaksi->where('status_pembayaran', 'batal')->count() }}</strong>
        </span>
    </div>

    <div class="report-table-wrap">
        <table class="report-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tgl. Pemesanan</th>
                    <th>Periode Sewa</th>
                    <th>Pengguna</th>
                    <th>Mobil</th>
                    <th class="num">Total Harga</th>
                    <th class="center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksi as $t)
                    <tr>
                        <td>{{ $t->id }}</td>
                        <td>{{ date('d M Y', strtotime($t->tanggal_pemesanan)) }}</td>
                        <td>
                            {{ date('d M Y', strtotime($t->tanggal_mulai)) }}
                            &rarr;
                            {{ date('d M Y', strtotime($t->tanggal_selesai)) }}
                        </td>
                        <td>{{ $t->pengguna->nama ?? '-' }}</td>
                        <td>{{ $t->mobil->nama_mobil ?? '-' }}</td>
                        <td class="num">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                        <td class="center">
                            @switch($t->status_pembayaran)
                                @case('lunas')
                                    <span class="report-badge report-badge-success">Lunas</span>
                                    @break
                                @case('pending')
                                    <span class="report-badge report-badge-warning">Pending</span>
                                    @break
                                @case('batal')
                                    <span class="report-badge report-badge-danger">Batal</span>
                                    @break
                                @default
                                    <span class="report-badge report-badge-neutral">{{ $t->status_pembayaran }}</span>
                            @endswitch
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="center">Tidak ada data transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="report-summary">
        <div class="report-summary-box">
            <div class="label">Total Pendapatan (Lunas)</div>
            <div class="value">Rp {{ number_format($totalLunas, 0, ',', '.') }}</div>
        </div>
    </div>
@endsection
