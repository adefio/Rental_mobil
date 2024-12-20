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
                                    <th>Nama Pengguna</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>No. Telepon</th>
                                    <th>Alamat</th>
                                    <th>Created</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengguna as $p)
                                    <tr>
                                        <td>{{ $p->id }}</td>
                                        <td>{{ $p->nama }}</td>
                                        <td>{{ $p->email }}</td>
                                        <td>{{ $p->role }}</td>
                                        <td>{{ $p->no_telepon }}</td>
                                        <td>{{ $p->alamat }}</td>
                                        <td>{{ $p->created_at }}</td>
                                        <td>
                                            <a href="{{ url('pengguna/' . $p->id . '/edit') }}"
                                                class="btn btn-primary btn-sm">Edit</a>

                                            <form action="{{ url('pengguna/' . $p->id) }}" method="post" class="d-inline"
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
                        {{ $pengguna->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
