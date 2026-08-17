@extends('layouts.admin')

@section('title', 'Pengaturan')

@section('content')
    <div class="admin-page-header mb-4">
        <h1 class="admin-page-title mb-1">Pengaturan</h1>
        <p class="admin-page-sub mb-0">Atur identitas bisnis dan informasi operasional yang tampil di aplikasi.</p>
    </div>

    <form method="POST" action="{{ route('admin.pengaturan.update') }}" id="formPengaturan">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card page-card mb-4">
                    <div class="card-header d-flex align-items-center gap-2">
                        <span class="profile-section-icon"><x-icon name="building" class="icon-sm" /></span>
                        <span>Identitas Usaha</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nama_aplikasi" class="form-label">Nama Aplikasi</label>
                                <input id="nama_aplikasi" type="text"
                                    class="form-control @error('nama_aplikasi') is-invalid @enderror"
                                    name="nama_aplikasi" value="{{ old('nama_aplikasi', $settings['nama_aplikasi']) }}" required>

                                @error('nama_aplikasi')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="slogan" class="form-label">Slogan</label>
                                <input id="slogan" type="text"
                                    class="form-control @error('slogan') is-invalid @enderror"
                                    name="slogan" value="{{ old('slogan', $settings['slogan']) }}"
                                    placeholder="Tagline singkat usaha Anda">

                                @error('slogan')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card page-card mb-4">
                    <div class="card-header d-flex align-items-center gap-2">
                        <span class="profile-section-icon"><x-icon name="map-pin" class="icon-sm" /></span>
                        <span>Kontak & Lokasi</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="no_telepon" class="form-label">No. Telepon</label>
                                <input id="no_telepon" type="text"
                                    class="form-control @error('no_telepon') is-invalid @enderror"
                                    name="no_telepon" value="{{ old('no_telepon', $settings['no_telepon']) }}"
                                    placeholder="+62 812-3456-7890">

                                @error('no_telepon')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email_kontak" class="form-label">Email Kontak</label>
                                <input id="email_kontak" type="email"
                                    class="form-control @error('email_kontak') is-invalid @enderror"
                                    name="email_kontak" value="{{ old('email_kontak', $settings['email_kontak']) }}"
                                    placeholder="halo@perusahaan.com">

                                @error('email_kontak')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input id="alamat" type="text"
                                    class="form-control @error('alamat') is-invalid @enderror"
                                    name="alamat" value="{{ old('alamat', $settings['alamat']) }}"
                                    placeholder="Alamat lengkap usaha">

                                @error('alamat')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card page-card mb-4">
                    <div class="card-header d-flex align-items-center gap-2">
                        <span class="profile-section-icon"><x-icon name="send" class="icon-sm" /></span>
                        <span>Media Sosial</span>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-muted small mb-3">
                            Tautan media sosial ini tampil di footer situs publik. Kosongkan jika tidak digunakan.
                        </p>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="facebook" class="form-label">Facebook</label>
                                <input id="facebook" type="url"
                                    class="form-control @error('facebook') is-invalid @enderror"
                                    name="facebook" value="{{ old('facebook', $settings['facebook']) }}"
                                    placeholder="https://facebook.com/halaman-anda">

                                @error('facebook')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="instagram" class="form-label">Instagram</label>
                                <input id="instagram" type="url"
                                    class="form-control @error('instagram') is-invalid @enderror"
                                    name="instagram" value="{{ old('instagram', $settings['instagram']) }}"
                                    placeholder="https://instagram.com/halaman-anda">

                                @error('instagram')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="twitter" class="form-label">Twitter / X</label>
                                <input id="twitter" type="url"
                                    class="form-control @error('twitter') is-invalid @enderror"
                                    name="twitter" value="{{ old('twitter', $settings['twitter']) }}"
                                    placeholder="https://twitter.com/halaman-anda">

                                @error('twitter')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="youtube" class="form-label">YouTube</label>
                                <input id="youtube" type="url"
                                    class="form-control @error('youtube') is-invalid @enderror"
                                    name="youtube" value="{{ old('youtube', $settings['youtube']) }}"
                                    placeholder="https://youtube.com/@channel-anda">

                                @error('youtube')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card page-card mb-4">
                    <div class="card-header d-flex align-items-center gap-2">
                        <span class="profile-section-icon"><x-icon name="clock" class="icon-sm" /></span>
                        <span>Operasional & Kebijakan</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="jam_operasional" class="form-label">Jam Operasional</label>
                                <input id="jam_operasional" type="text"
                                    class="form-control @error('jam_operasional') is-invalid @enderror"
                                    name="jam_operasional" value="{{ old('jam_operasional', $settings['jam_operasional']) }}"
                                    placeholder="08.00 - 20.00 WIB">

                                @error('jam_operasional')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="tarif_denda_per_hari" class="form-label">Tarif Denda per Hari (Rp)</label>
                                <input id="tarif_denda_per_hari" type="number" min="0"
                                    class="form-control @error('tarif_denda_per_hari') is-invalid @enderror"
                                    name="tarif_denda_per_hari" value="{{ old('tarif_denda_per_hari', $settings['tarif_denda_per_hari']) }}">

                                @error('tarif_denda_per_hari')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="alert profile-security-note d-flex align-items-start gap-2 mt-3 mb-0" role="alert">
                            <x-icon name="info" class="icon-sm mt-1" />
                            <div>
                                <strong>Informasi ini akan tampil di situs publik.</strong>
                                Perubahan tersimpan langsung dan digunakan pada halaman depan, kontak, dan footer.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card page-card settings-summary-card">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="profile-section-icon"><x-icon name="check-circle" class="icon-sm" /></span>
                            <span class="fw-semibold">Ringkasan</span>
                        </div>
                        <ul class="settings-summary-list">
                            <li>
                                <span class="settings-summary-label">Nama Aplikasi</span>
                                <span class="settings-summary-value" id="sumNama">{{ $settings['nama_aplikasi'] }}</span>
                            </li>
                            <li>
                                <span class="settings-summary-label">No. Telepon</span>
                                <span class="settings-summary-value" id="sumTelepon">{{ $settings['no_telepon'] }}</span>
                            </li>
                            <li>
                                <span class="settings-summary-label">Email Kontak</span>
                                <span class="settings-summary-value" id="sumEmail">{{ $settings['email_kontak'] }}</span>
                            </li>
                            <li>
                                <span class="settings-summary-label">Jam Operasional</span>
                                <span class="settings-summary-value" id="sumJam">{{ $settings['jam_operasional'] }}</span>
                            </li>
                        </ul>
                        <hr>
                        <p class="small text-muted mb-0">
                            <x-icon name="shield" class="icon-sm" />
                            Data ini aman tersimpan dan hanya dapat diubah oleh administrator.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="settings-save-bar">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="small text-muted">
                    <x-icon name="info" class="icon-sm" />
                    Perubahan akan diterapkan langsung di seluruh aplikasi.
                </div>
                <button type="submit" class="btn btn-primary px-4">
                    <x-icon name="check" class="icon-sm" />
                    Simpan Pengaturan
                </button>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        const namaInput = document.getElementById('nama_aplikasi');
        const teleponInput = document.getElementById('no_telepon');
        const emailInput = document.getElementById('email_kontak');
        const jamInput = document.getElementById('jam_operasional');

        const updateSummary = function () {
            document.getElementById('sumNama').textContent = namaInput.value || '-';
            document.getElementById('sumTelepon').textContent = teleponInput.value || '-';
            document.getElementById('sumEmail').textContent = emailInput.value || '-';
            document.getElementById('sumJam').textContent = jamInput.value || '-';
        };

        namaInput.addEventListener('input', updateSummary);
        teleponInput.addEventListener('input', updateSummary);
        emailInput.addEventListener('input', updateSummary);
        jamInput.addEventListener('input', updateSummary);
    </script>
@endpush
