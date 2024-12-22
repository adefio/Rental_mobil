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
                                    <th>ID</th>
                                    <th>ID Transaksi</th>
                                    <th>Nama Pengguna</th>
                                    <th>Nama Mobil</th>
                                    <th>Denda Telat</th>
                                    <th>Biaya Kerusakan</th>
                                    <th>Deskripsi Kerusakan</th>
                                    <th>Tanggal Pengembalian</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengembalian as $p)
                                    <tr>
                                        <td>{{ $p->id }}</td>
                                        <td>{{ $p->transaksi->id }}</td>
                                        <td>{{ $p->transaksi->pengguna->nama }}</td>
                                        <td>{{ $p->transaksi->mobil->nama_mobil }}</td>
                                        <td>{{ $p->denda_telat }}</td>
                                        <td>{{ $p->biaya_kerusakan }}</td>
                                        <td>{{ $p->deskripsi_kerusakan }}</td>
                                        <td>{{ $p->tanggal_pengembalian }}</td>
                                        <td>
                                            <a href="{{ url('pengembalian/' . $p->id . '/edit') }}"
                                                class="btn btn-primary btn-sm">Edit</a>

                                            <form action="{{ url('pengembalian/' . $p->id) }}" method="post"
                                                class="d-inline"
                                                onsubmit="return confirm('Apakah Anda Yakin Ingin Menghapus?')">
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
                        {{ $pengembalian->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
