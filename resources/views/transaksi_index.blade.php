@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ $judul }}
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Pemesanan</th>
                                    <th>Nama Pengguna</th>
                                    <th>Mobil</th>
                                    <th>Total Harga</th>
                                    <th>Status Pembayaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaksi as $t)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ date('d M Y', strtotime($t->tanggal_pemesanan)) }}</td>
                                        <td>{{ $t->pengguna->nama }}</td>
                                        <td>{{ $t->mobil->nama_mobil }}</td>
                                        <td>Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                                        <td>{{ ucfirst($t->status_pembayaran) }}</td>
                                        <td>
                                            <a href="{{ url('transaksi/' . $t->id . '/edit') }}"
                                                class="btn btn-primary btn-sm">Edit</a>

                                            <form action="{{ url('transaksi/' . $t->id) }}" method="post" class="d-inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus?')">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        {{ $transaksi->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
