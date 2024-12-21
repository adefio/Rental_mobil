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
                                    <th>Nama Mobil</th>
                                    <th>Merk</th>
                                    <th>Tahun</th>
                                    <th>Harga Sewa</th>
                                    <th>Status</th>
                                    <th>Deskripsi</th>
                                    <th>Created</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mobil as $m)
                                    <tr>
                                        <td>{{ $m->id }}</td>
                                        <td>{{ $m->nama_mobil }}</td>
                                        <td>{{ $m->merk }}</td>
                                        <td>{{ $m->tahun }}</td>
                                        <td>Rp {{ number_format($m->harga_sewa, 2, ',', '.') }}</td>
                                        <td>{{ $m->status }}</td>
                                        <td>{{ $m->deskripsi }}</td>
                                        <td>{{ $m->created_at }}</td>
                                        <td>
                                            <a href="{{ url('mobil/' . $m->id . '/edit') }}"
                                                class="btn btn-primary btn-sm">Edit</a>

                                            <form action="{{ url('mobil/' . $m->id) }}" method="post" class="d-inline"
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
                        {{ $mobil->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
