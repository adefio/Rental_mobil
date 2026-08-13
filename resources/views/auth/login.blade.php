@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')
    <h4 class="fw-bold text-center mb-1">Selamat Datang Kembali</h4>
    <p class="text-muted text-center small mb-4">Masuk untuk mengelola pemesanan Anda</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email</label>
            <input id="email" type="email"
                class="form-control @error('email') is-invalid @enderror" name="email"
                value="{{ old('email') }}" required autocomplete="email" autofocus
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
                required autocomplete="current-password" placeholder="Password Anda">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                    {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label small" for="remember">
                    Ingat saya
                </label>
            </div>

            @if (Route::has('password.request'))
                <a class="small text-decoration-none" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @endif
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
            Masuk
        </button>
    </form>

    <p class="text-center small text-muted mt-4 mb-0">
        Belum punya akun?
        <a href="{{ route('register') }}" class="fw-semibold text-decoration-none">Daftar di sini</a>
    </p>
@endsection
