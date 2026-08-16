@extends('layouts.auth')

@section('title', 'Konfirmasi Password')

@section('content')
    <h4 class="fw-bold text-center mb-1">Konfirmasi Password</h4>
    <p class="text-muted text-center small mb-4">Masukkan password Anda untuk melanjutkan</p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Password</label>
            <input id="password" type="password"
                class="form-control @error('password') is-invalid @enderror" name="password"
                required autocomplete="current-password" autofocus placeholder="Password Anda">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
            Konfirmasi
        </button>

        @if (Route::has('password.request'))
            <p class="text-center small mt-3 mb-0">
                <a href="{{ route('password.request') }}" class="text-decoration-none">Lupa password?</a>
            </p>
        @endif
    </form>
@endsection
