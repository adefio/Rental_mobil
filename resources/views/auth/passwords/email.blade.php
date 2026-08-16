@extends('layouts.auth')

@section('title', 'Lupa Password')

@section('content')
    <h4 class="fw-bold text-center mb-1">Lupa Password</h4>
    <p class="text-muted text-center small mb-4">Kami akan mengirim tautan reset ke email Anda</p>

    @if (session('status'))
        <div class="alert alert-success small" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
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

        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
            Kirim Tautan Reset
        </button>
    </form>

    <p class="text-center small text-muted mt-4 mb-0">
        Sudah ingat password?
        <a href="{{ route('login') }}" class="fw-semibold text-decoration-none">Masuk di sini</a>
    </p>
@endsection
