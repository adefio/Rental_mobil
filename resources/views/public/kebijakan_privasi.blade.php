@extends('layouts.public')

@section('title', 'Kebijakan Privasi')

@section('content')
    <section class="page-header">
        <div class="container text-center">
            <h1 class="fw-bold">Kebijakan Privasi</h1>
            <p class="text-white-50">Bagaimana kami mengelola dan melindungi data Anda</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="booking-card card shadow-sm p-0">
                        <div class="card-body p-4 p-md-5">
                            <div class="mb-4">
                                <h2 class="h5 fw-bold mb-2">1. Informasi yang Kami Kumpulkan</h2>
                                <p class="text-muted mb-0">
                                    Kami mengumpulkan data yang Anda berikan saat mendaftar atau memesan,
                                    antara lain nama, alamat email, nomor telepon, alamat, dan data pemesanan
                                    seperti tanggal sewa serta bukti pembayaran.
                                </p>
                            </div>

                            <div class="mb-4">
                                <h2 class="h5 fw-bold mb-2">2. Penggunaan Data</h2>
                                <p class="text-muted mb-0">
                                    Data digunakan untuk memproses pemesanan, memverifikasi pembayaran,
                                    menghubungi Anda terkait layanan, serta meningkatkan kualitas pelayanan kami.
                                </p>
                            </div>

                            <div class="mb-4">
                                <h2 class="h5 fw-bold mb-2">3. Penyimpanan dan Keamanan</h2>
                                <p class="text-muted mb-0">
                                    Data disimpan dengan aman dan hanya dapat diakses oleh pihak yang berwenang.
                                    Kami menerapkan langkah pengamanan untuk melindungi data Anda dari akses yang tidak sah.
                                </p>
                            </div>

                            <div class="mb-4">
                                <h2 class="h5 fw-bold mb-2">4. Berbagi Data</h2>
                                <p class="text-muted mb-0">
                                    Kami tidak menjual atau menyewakan data pribadi Anda kepada pihak ketiga.
                                    Data hanya dibagikan apabila diwajibkan oleh hukum atau untuk keperluan operasional layanan.
                                </p>
                            </div>

                            <div class="mb-4">
                                <h2 class="h5 fw-bold mb-2">5. Hak Anda</h2>
                                <p class="text-muted mb-0">
                                    Anda berhak meminta akses, perbaikan, atau penghapusan data pribadi Anda
                                    dengan menghubungi kami melalui halaman <a href="{{ url('kontak') }}">kontak</a>.
                                </p>
                            </div>

                            <div class="mb-0">
                                <h2 class="h5 fw-bold mb-2">6. Perubahan Kebijakan</h2>
                                <p class="text-muted mb-0">
                                    Kebijakan privasi ini dapat diperbarui sewaktu-waktu. Perubahan akan kami
                                    umumkan melalui situs ini.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
