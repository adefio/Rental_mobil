@extends('layouts.report')

@section('report-content')
    <div class="report-info-bar">
        <span class="report-info-item">
            <x-icon name="users" class="icon-sm" />
            Total Pengguna: <strong>{{ count($pengguna) }}</strong>
        </span>
        <span class="report-info-item">
            <x-icon name="user" class="icon-sm" />
            Pelanggan: <strong>{{ $pengguna->where('role', 'pelanggan')->count() }}</strong>
        </span>
    </div>

    <div class="report-table-wrap">
        <table class="report-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>No. HP</th>
                    <th>Alamat</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengguna as $a)
                    <tr>
                        <td>{{ $a->id }}</td>
                        <td><strong>{{ $a->nama }}</strong></td>
                        <td>{{ $a->email ?? '-' }}</td>
                        <td>{{ $a->no_telepon ?? '-' }}</td>
                        <td>{{ $a->alamat ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="center">Tidak ada data pengguna.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
