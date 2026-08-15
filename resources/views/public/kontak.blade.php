@extends('layouts.public')

@section('title', 'Kontak')

@section('content')
    <section class="page-header">
        <div class="container text-center">
            <h1 class="fw-bold">Hubungi Kami</h1>
            <p class="text-white-50">Kami siap membantu pertanyaan Anda</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-md-6 col-lg-3">
                    <div class="detail-spec p-3">
                        <div class="spec-icon"><x-icon name="phone" /></div>
                        <small>Telepon</small>
                        <div class="fw-bold">+62 812-3456-7890</div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="detail-spec p-3">
                        <div class="spec-icon"><x-icon name="message-circle" /></div>
                        <small>WhatsApp</small>
                        <div class="fw-bold">+62 812-3456-7890</div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="detail-spec p-3">
                        <div class="spec-icon"><x-icon name="mail" /></div>
                        <small>Email</small>
                        <div class="fw-bold">halo@rentalmobil.com</div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="detail-spec p-3">
                        <div class="spec-icon"><x-icon name="clock" /></div>
                        <small>Jam Operasional</small>
                        <div class="fw-bold">08.00 - 20.00 WIB</div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="booking-card card shadow-sm p-0">
                        <div class="card-header bg-transparent border-0">
                            <h5 class="fw-bold mb-0">Lokasi Kami</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-2 d-flex align-items-center gap-2">
                                <x-icon name="map-pin" class="icon text-primary" /> Jl. Raya Rental No. 123, Jakarta Selatan
                            </p>
                            <p class="text-muted mb-0">
                                Mudah diakses dan dekat dengan jalur utama. Tersedia area parkir
                                yang luas untuk kemudahan Anda saat mengambil atau mengembalikan mobil.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="booking-card card shadow-sm p-0">
                        <div class="card-header bg-transparent border-0">
                            <h5 class="fw-bold mb-0">Kirim Pesan</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('kontak.kirim') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="nama" class="form-label fw-semibold">Nama</label>
                                    <input type="text" id="nama" name="nama"
                                        class="form-control @error('nama') is-invalid @enderror"
                                        value="{{ old('nama') }}" required>
                                    @error('nama')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">Email</label>
                                    <input type="email" id="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" required>
                                    @error('email')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="no_telepon" class="form-label fw-semibold">No. Telepon <span class="text-muted">(opsional)</span></label>
                                    <input type="text" id="no_telepon" name="no_telepon"
                                        class="form-control @error('no_telepon') is-invalid @enderror"
                                        value="{{ old('no_telepon') }}" placeholder="08xx-xxxx-xxxx">
                                    @error('no_telepon')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="subjek" class="form-label fw-semibold">Subjek <span class="text-muted">(opsional)</span></label>
                                    <input type="text" id="subjek" name="subjek"
                                        class="form-control @error('subjek') is-invalid @enderror"
                                        value="{{ old('subjek') }}">
                                    @error('subjek')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="pesan" class="form-label fw-semibold">Pesan</label>
                                    <textarea id="pesan" name="pesan" rows="4"
                                        class="form-control @error('pesan') is-invalid @enderror"
                                        required>{{ old('pesan') }}</textarea>
                                    @error('pesan')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                                    Kirim Pesan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
