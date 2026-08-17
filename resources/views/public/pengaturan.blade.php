@extends('layouts.public')

@section('title', 'Pengaturan Akun')
@section('meta_description', 'Kelola pengaturan akun rental mobil Anda.')

@section('content')
    <section class="page-header">
        <div class="container">
            <h1 class="fw-bold mb-0">Pengaturan Akun</h1>
            <p class="text-white-50 mb-0">Kelola profil dan keamanan akun Anda</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <form method="POST" action="{{ route('pengaturan.akun.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="card shadow-sm">
                            <div class="card-body p-4 text-center">
                                <div class="profile-photo-wrap mx-auto">
                                    <img id="avatarPreview" class="profile-photo"
                                        src="{{ $user->avatar_url ?? '' }}" alt="Foto profil"
                                        style="{{ $user->avatar_url ? '' : 'display:none;' }}">
                                    <span id="avatarInitial" class="profile-photo-initial"
                                        style="{{ $user->avatar_url ? 'display:none;' : '' }}">
                                        {{ $user->avatar_initial }}
                                    </span>
                                    <label for="foto_profil" class="profile-photo-edit" title="Ganti foto profil">
                                        <x-icon name="camera" />
                                    </label>
                                </div>
                                <input type="file" id="foto_profil" name="foto_profil" accept="image/*"
                                    class="d-none">

                                @error('foto_profil')
                                    <small class="text-danger d-block mt-2">{{ $message }}</small>
                                @enderror

                                <h5 class="fw-bold mt-3 mb-0">{{ $pengguna->nama ?? $user->name }}</h5>
                                <p class="text-muted small mb-2">{{ $pengguna->email ?? $user->email }}</p>
                                <span class="badge {{ $user->isAdmin() ? 'bg-danger' : 'bg-primary' }}">
                                    {{ $user->isAdmin() ? 'Admin' : 'Pelanggan' }}
                                </span>

                                <hr>

                                <div class="text-start small">
                                    <div class="d-flex justify-content-between py-1">
                                        <span class="text-muted">Terdaftar sejak</span>
                                        <span class="fw-semibold text-dark">
                                            {{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('d M Y') }}
                                        </span>
                                    </div>
                                    @if (($pengguna->no_telepon ?? null) || ($pengguna->alamat ?? null))
                                        @if ($pengguna->no_telepon)
                                            <div class="d-flex justify-content-between py-1">
                                                <span class="text-muted">No. Telepon</span>
                                                <span class="fw-semibold text-dark">{{ $pengguna->no_telepon }}</span>
                                            </div>
                                        @endif
                                        @if ($pengguna->alamat)
                                            <div class="d-flex justify-content-between py-1">
                                                <span class="text-muted">Alamat</span>
                                                <span class="fw-semibold text-dark text-end ms-3">{{ $pengguna->alamat }}</span>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="card shadow-sm">
                            <div class="card-header bg-transparent py-3 border-bottom">
                                <h5 class="mb-0 fw-bold">Informasi Profil</h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <label for="nama" class="form-label fw-semibold">Nama Lengkap</label>
                                    <input id="nama" type="text"
                                        class="form-control @error('nama') is-invalid @enderror" name="nama"
                                        value="{{ old('nama', $pengguna->nama ?? $user->name) }}" required>

                                    @error('nama')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">Email</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email', $pengguna->email ?? $user->email) }}" required>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="no_telepon" class="form-label fw-semibold">No. Telepon</label>
                                        <input id="no_telepon" type="text"
                                            class="form-control @error('no_telepon') is-invalid @enderror"
                                            name="no_telepon" value="{{ old('no_telepon', $pengguna->no_telepon ?? '') }}"
                                            placeholder="08xx-xxxx-xxxx">

                                        @error('no_telepon')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="alamat" class="form-label fw-semibold">Alamat</label>
                                        <input id="alamat" type="text"
                                            class="form-control @error('alamat') is-invalid @enderror" name="alamat"
                                            value="{{ old('alamat', $pengguna->alamat ?? '') }}"
                                            placeholder="Alamat lengkap Anda">

                                        @error('alamat')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm mt-4">
                            <div class="card-header bg-transparent py-3 border-bottom">
                                <h5 class="mb-0 fw-bold">Kata Sandi</h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="password" class="form-label fw-semibold">Kata Sandi Baru</label>
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            autocomplete="new-password" placeholder="Kosongkan jika tidak diubah">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password-confirm" class="form-label fw-semibold">Konfirmasi Kata Sandi</label>
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" autocomplete="new-password"
                                            placeholder="Ulangi kata sandi baru">
                                    </div>
                                </div>
                                <div class="form-text mt-2">
                                    Gunakan minimal 8 karakter untuk keamanan akun yang lebih baik.
                                </div>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg py-2 fw-semibold">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
