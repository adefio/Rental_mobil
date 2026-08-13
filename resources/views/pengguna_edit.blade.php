@extends('layouts.admin')

@section('title', 'Edit Pengguna')

@section('content')
    <div class="card page-card form-card">
        <div class="card-header">
            <a href="{{ url('pengguna') }}" class="btn btn-light btn-back" aria-label="Kembali ke Data Pengguna">
                <x-icon name="arrow-left" class="icon-sm" />
            </a>
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
                    <input id="role" class="form-control" type="text" value="Pelanggan" disabled>
                    <small class="text-muted">Akun admin dikelola melalui halaman Pengaturan Akun.</small>
                    <input type="hidden" name="role" value="pelanggan">
                </div>

                <div class="form-group">
                    <label for="no_telepon">No HP</label>
                    <input id="no_telepon" class="form-control" type="text" name="no_telepon"
                        value="{{ $pengguna->no_telepon ?? old('no_telepon') }}">
                    <span class="text-danger">{{ $errors->first('no_telepon') }}</span>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea id="alamat" class="form-control" name="alamat" rows="3">{{ $pengguna->alamat ?? old('alamat') }}</textarea>
                    <span class="text-danger">{{ $errors->first('alamat') }}</span>
                </div>

                <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-2">
                    <x-icon name="check" class="icon-sm" />Update</button>
                <a href="{{ url('pengguna') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
