@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
    <h4 class="fw-bold text-center mb-1">Buat Password Baru</h4>
    <p class="text-muted text-center small mb-4">Masukkan password baru untuk akun Anda</p>

    <form method="POST" action="{{ route('password.reset.complete.post') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Password Baru</label>
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
                placeholder="Ulangi password baru">

            @error('token')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
            Simpan Password Baru
        </button>
    </form>

    <p class="text-center small text-muted mt-4 mb-0">
        <a href="{{ route('login') }}" class="fw-semibold text-decoration-none">Kembali ke halaman masuk</a>
    </p>
@endsection
