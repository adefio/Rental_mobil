@extends('layouts.report')

@section('report-content')
    <div class="report-info-bar">
        <span class="report-info-item">
            <x-icon name="car" class="icon-sm" />
            Total Mobil: <strong>{{ count($mobil) }}</strong>
        </span>
        <span class="report-info-item">
            <x-icon name="check-circle" class="icon-sm" />
            Tersedia: <strong>{{ $mobil->where('status', 'tersedia')->count() }}</strong>
        </span>
        <span class="report-info-item">
            <x-icon name="clock" class="icon-sm" />
            Disewa: <strong>{{ $mobil->where('status', 'disewa')->count() }}</strong>
        </span>
        <span class="report-info-item">
            <x-icon name="shield" class="icon-sm" />
            Maintenance: <strong>{{ $mobil->where('status', 'maintenance')->count() }}</strong>
        </span>
    </div>

    <div class="report-table-wrap">
        <table class="report-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Mobil</th>
                    <th>Merk</th>
                    <th>Tahun</th>
                    <th class="num">Harga Sewa</th>
                    <th class="center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mobil as $m)
                    <tr>
                        <td>{{ $m->id }}</td>
                        <td><strong>{{ $m->nama_mobil }}</strong></td>
                        <td>{{ $m->merk }}</td>
                        <td>{{ $m->tahun }}</td>
                        <td class="num">Rp {{ number_format($m->harga_sewa, 0, ',', '.') }}</td>
                        <td class="center">
                            @switch($m->status)
                                @case('tersedia')
                                    <span class="report-badge report-badge-success">Tersedia</span>
                                    @break
                                @case('disewa')
                                    <span class="report-badge report-badge-warning">Disewa</span>
                                    @break
                                @case('maintenance')
                                    <span class="report-badge report-badge-danger">Maintenance</span>
                                    @break
                                @default
                                    <span class="report-badge report-badge-neutral">{{ $m->status }}</span>
                            @endswitch
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="center">Tidak ada data mobil.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
