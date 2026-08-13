@extends('layouts.admin')

@section('title', 'Profil Admin')

@section('content')
    <div class="admin-page-header d-flex flex-wrap align-items-end justify-content-between gap-3">
        <div>
            <h1 class="admin-page-title mb-1">Profil Admin</h1>
            <p class="admin-page-sub mb-0">Kelola identitas, kontak, dan keamanan akun Anda.</p>
        </div>
        <span class="badge badge-status bg-primary-subtle text-primary">Level Akses: Admin</span>
    </div>

    <form method="POST" action="{{ route('admin.profil.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card profile-identity-card h-100">
                    <div class="profile-cover"></div>

                    <div class="card-body text-center px-4 pt-0">
                        <div class="profile-avatar-wrap mx-auto">
                            <img id="avatarPreview" class="profile-avatar-lg"
                                src="{{ $user->avatar_url ?? '' }}" alt="Foto profil admin"
                                style="{{ $user->avatar_url ? '' : 'display:none;' }}">
                            <span id="avatarInitial" class="profile-avatar-initial"
                                style="{{ $user->avatar_url ? 'display:none;' : '' }}">
                                {{ $user->avatar_initial }}
                            </span>
                            <label for="foto_profil" class="profile-avatar-edit" title="Ganti foto profil">
                                <x-icon name="camera" />
                            </label>
                        </div>
                        <input type="file" id="foto_profil" name="foto_profil" accept="image/*" class="d-none">

                        @error('foto_profil')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror

                        <h5 class="fw-bold mt-3 mb-0">{{ $pengguna->nama ?? $user->name }}</h5>
                        <p class="text-muted small mb-2">{{ $pengguna->email ?? $user->email }}</p>

                        <div class="d-flex justify-content-center gap-2">
                            <span class="badge profile-role-badge">
                                <x-icon name="shield" class="icon-sm" />
                                Administrator
                            </span>
                        </div>

                        <hr>

                        <div class="text-start small">
                            <div class="profile-info-row">
                                <span class="profile-info-label">
                                    <x-icon name="calendar" class="icon-sm" />
                                    Terdaftar sejak
                                </span>
                                <span class="profile-info-value">
                                    {{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('d M Y') }}
                                </span>
                            </div>

                            @if ($pengguna->no_telepon ?? null)
                                <div class="profile-info-row">
                                    <span class="profile-info-label">
                                        <x-icon name="phone" class="icon-sm" />
                                        No. Telepon
                                    </span>
                                    <span class="profile-info-value">{{ $pengguna->no_telepon }}</span>
                                </div>
                            @endif

                            @if ($pengguna->alamat ?? null)
                                <div class="profile-info-row">
                                    <span class="profile-info-label">
                                        <x-icon name="map-pin" class="icon-sm" />
                                        Alamat
                                    </span>
                                    <span class="profile-info-value text-end">{{ $pengguna->alamat }}</span>
                                </div>
                            @endif

                            @if ($pengguna->updated_at ?? null)
                                <div class="profile-info-row">
                                    <span class="profile-info-label">
                                        <x-icon name="refresh" class="icon-sm" />
                                        Terakhir diubah
                                    </span>
                                    <span class="profile-info-value">
                                        {{ \Carbon\Carbon::parse($pengguna->updated_at)->diffForHumans() }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <hr>

                        <div class="d-grid">
                            <button type="button" class="btn btn-outline-primary btn-sm"
                                onclick="new bootstrap.Modal(document.getElementById('logoutModal')).show();">
                                <x-icon name="log-out" class="icon-sm" />
                                Keluar dari Akun
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card page-card mb-4">
                    <div class="card-header d-flex align-items-center gap-2">
                        <span class="profile-section-icon"><x-icon name="users" class="icon-sm" /></span>
                        <span>Informasi Profil</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input id="nama" type="text"
                                    class="form-control @error('nama') is-invalid @enderror" name="nama"
                                    value="{{ old('nama', $pengguna->nama ?? $user->name) }}" required>

                                @error('nama')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email', $pengguna->email ?? $user->email) }}" required>

                                @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="no_telepon" class="form-label">No. Telepon</label>
                                <input id="no_telepon" type="text"
                                    class="form-control @error('no_telepon') is-invalid @enderror" name="no_telepon"
                                    value="{{ old('no_telepon', $pengguna->no_telepon ?? '') }}"
                                    placeholder="08xx-xxxx-xxxx">

                                @error('no_telepon')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input id="alamat" type="text"
                                    class="form-control @error('alamat') is-invalid @enderror" name="alamat"
                                    value="{{ old('alamat', $pengguna->alamat ?? '') }}"
                                    placeholder="Alamat lengkap Anda">

                                @error('alamat')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card page-card mb-4">
                    <div class="card-header d-flex align-items-center gap-2">
                        <span class="profile-section-icon"><x-icon name="key" class="icon-sm" /></span>
                        <span>Keamanan Akun</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert profile-security-note d-flex align-items-start gap-2 mb-3" role="alert">
                            <x-icon name="shield" class="icon-sm mt-1" />
                            <div>
                                <strong>Jaga keamanan akun Anda.</strong>
                                Gunakan kombinasi huruf, angka, dan simbol minimal 8 karakter.
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label">Kata Sandi Baru</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    autocomplete="new-password" placeholder="Kosongkan jika tidak diubah">

                                @error('password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password-confirm" class="form-label">Konfirmasi Kata Sandi</label>
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" autocomplete="new-password"
                                    placeholder="Ulangi kata sandi baru">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card page-card">
                    <div class="card-body p-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div class="small text-muted">
                            <x-icon name="info" class="icon-sm" />
                            Perubahan akan langsung diterapkan ke akun Anda.
                        </div>
                        <button type="submit" class="btn btn-primary px-4">
                            <x-icon name="check" class="icon-sm" />
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
