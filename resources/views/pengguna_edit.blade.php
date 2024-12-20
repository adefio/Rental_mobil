@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Edit Data Pengguna
                    </div>
                    <div class="card-body">
                        <form action="{{ url('pengguna/' . $pengguna->id) }}" method="POST">
                            @method('PUT')
                            @csrf

                            <div class="form-group">
                                <label for="nama">Nama Pengguna</label>
                                <input id="nama" class="form-control" type="text" name="nama"
                                    value="{{ $pengguna->nama ?? old('nama') }}">
                                <span class="text-danger">{{ $errors->first('nama') }}</span>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" class="form-control" type="email" name="email"
                                    value="{{ $pengguna->email ?? old('email') }}">
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            </div>

                            <div class="form-group">
                                <label for="role">Role</label>
                                <select id="role" class="form-control" name="role">
                                    <option value="pelanggan" @selected('pelanggan' == $pengguna->role)>Pelanggan</option>
                                    <option value="admin" @selected('admin' == $pengguna->role)>Admin</option>
                                </select>
                                <span class="text-danger">{{ $errors->first('role') }}</span>
                            </div>

                            <div class="form-group">
                                <label for="no_telepon">No HP</label>
                                <input id="no_telepon" class="form-control" type="text" name="no_telepon"
                                    value="{{ $pengguna->no_telepon ?? old('no_telepon') }}">
                                <span class="text-danger">{{ $errors->first('no_telepon') }}</span>
                            </div>

                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea id="alamat" class="form-control" name="alamat">{{ $pengguna->alamat ?? old('alamat') }}</textarea>
                                <span class="text-danger">{{ $errors->first('alamat') }}</span>
                            </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
