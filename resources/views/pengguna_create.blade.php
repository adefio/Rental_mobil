@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Tambah Data Pengguna
                    </div>
                    <div class="card-body">
                        <form action="{{ url('pengguna') }}" method="POST">
                            @method('POST')
                            @csrf

                            <div class="form-group">
                                <label for="nama">Nama Pengguna</label>
                                <input id="nama" class="form-control" type="text" name="nama"
                                    value="{{ old('nama') }}">
                                <span class="text-danger">{{ $errors->first('nama') }}</span>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" class="form-control" type="email" name="email"
                                    value="{{ old('email') }}">
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" class="form-control" type="password" name="password"
                                    value="{{ old('password') }}">
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            </div>

                            <div class="form-group">
                                <label for="role">Role</label>
                                <select id="role" class="form-control" name="role">
                                    <option value="pelanggan" @selected('pelanggan' == old('role'))>Pelanggan</option>
                                    <option value="admin" @selected('admin' == old('role'))>Admin</option>
                                </select>
                                <span class="text-danger">{{ $errors->first('role') }}</span>
                            </div>

                            <div class="form-group">
                                <label for="no_telepon">No HP</label>
                                <input id="no_telepon" class="form-control" type="text" name="no_telepon"
                                    value="{{ old('no_telepon') }}">
                                <span class="text-danger">{{ $errors->first('no_telepon') }}</span>
                            </div>

                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea id="alamat" class="form-control" name="alamat">{{ old('alamat') }}</textarea>
                                <span class="text-danger">{{ $errors->first('alamat') }}</span>
                            </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
