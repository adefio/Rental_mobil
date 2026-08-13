@extends('layouts.auth')

@section('title', 'Daftar')

@section('content')
    <h4 class="fw-bold text-center mb-1">Buat Akun Baru</h4>
    <p class="text-muted text-center small mb-4">Daftar untuk mulai menyewa mobil</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
            <input id="name" type="text"
                class="form-control @error('name') is-invalid @enderror" name="name"
                value="{{ old('name') }}" required autocomplete="name" autofocus
                placeholder="Nama Anda">

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email</label>
            <input id="email" type="email"
                class="form-control @error('email') is-invalid @enderror" name="email"
                value="{{ old('email') }}" required autocomplete="email"
                placeholder="nama@email.com">

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Password</label>
            <input id="password" type="password"
                class="form-control @error('password') is-invalid @enderror" name="password"
                required autocomplete="new-password" placeholder="Minimal 8 karakter">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password-confirm" class="form-label fw-semibold">Konfirmasi Password</label>
            <input id="password-confirm" type="password" class="form-control"
                name="password_confirmation" required autocomplete="new-password"
                placeholder="Ulangi password">
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
            Daftar
        </button>
    </form>

    <p class="text-center small text-muted mt-4 mb-0">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="fw-semibold text-decoration-none">Masuk di sini</a>
    </p>
@endsection
