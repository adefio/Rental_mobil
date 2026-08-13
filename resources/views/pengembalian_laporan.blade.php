@extends('layouts.report')

@section('report-content')
    @php
        $totalDenda = $pengembalian->sum('denda_telat') + $pengembalian->sum('biaya_kerusakan');
    @endphp

    <div class="report-info-bar">
        <span class="report-info-item">
            <x-icon name="refresh" class="icon-sm" />
            Total Pengembalian: <strong>{{ count($pengembalian) }}</strong>
        </span>
        <span class="report-info-item">
            <x-icon name="wallet" class="icon-sm" />
            Total Denda + Kerusakan: <strong>Rp {{ number_format($totalDenda, 0, ',', '.') }}</strong>
        </span>
    </div>

    <div class="report-table-wrap">
        <table class="report-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID Transaksi</th>
                    <th>Pengguna</th>
                    <th>Mobil</th>
                    <th>Tgl. Pengembalian</th>
                    <th class="num">Denda Telat</th>
                    <th class="num">Biaya Kerusakan</th>
                    <th class="num">Total</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengembalian as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->transaksi_id }}</td>
                        <td>{{ optional($item->transaksi->pengguna)->nama ?? '-' }}</td>
                        <td>{{ optional($item->transaksi->mobil)->nama_mobil ?? '-' }}</td>
                        <td>{{ date('d M Y', strtotime($item->tanggal_pengembalian)) }}</td>
                        <td class="num">Rp {{ number_format($item->denda_telat, 0, ',', '.') }}</td>
                        <td class="num">Rp {{ number_format($item->biaya_kerusakan, 0, ',', '.') }}</td>
                        <td class="num">
                            <strong>Rp {{ number_format($item->denda_telat + $item->biaya_kerusakan, 0, ',', '.') }}</strong>
                        </td>
                        <td>{{ $item->deskripsi_kerusakan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="center">Tidak ada data pengembalian.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="report-summary">
        <div class="report-summary-box">
            <div class="label">Total Biaya Pengembalian</div>
            <div class="value">Rp {{ number_format($totalDenda, 0, ',', '.') }}</div>
        </div>
    </div>
@endsection
