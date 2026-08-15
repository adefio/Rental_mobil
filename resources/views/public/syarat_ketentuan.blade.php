@extends('layouts.public')

@section('title', 'Syarat & Ketentuan')

@section('content')
    <section class="page-header">
        <div class="container text-center">
            <h1 class="fw-bold">Syarat &amp; Ketentuan</h1>
            <p class="text-white-50">Ketentuan yang berlaku dalam layanan penyewaan mobil</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="booking-card card shadow-sm p-0">
                        <div class="card-body p-4 p-md-5">
                            <div class="mb-4">
                                <h2 class="h5 fw-bold mb-2">1. Pemesanan</h2>
                                <p class="text-muted mb-0">
                                    Pelanggan wajib memiliki akun dan data yang valid saat melakukan pemesanan.
                                    Pemesanan dianggap sah setelah tercatat pada sistem dengan status sesuai.
                                </p>
                            </div>

                            <div class="mb-4">
                                <h2 class="h5 fw-bold mb-2">2. Pembayaran</h2>
                                <p class="text-muted mb-0">
                                    Pembayaran dilakukan sesuai tarif yang tertera dan dikonfirmasi dengan
                                    mengirimkan bukti pembayaran. Pemesanan akan diproses setelah bukti diverifikasi admin.
                                </p>
                            </div>

                            <div class="mb-4">
                                <h2 class="h5 fw-bold mb-2">3. Pembatalan</h2>
                                <p class="text-muted mb-0">
                                    Pelanggan dapat membatalkan pemesanan selama statusnya masih menunggu pembayaran.
                                    Pemesanan yang sudah dibayar tidak dapat dibatalkan kecuali atas kesepakatan bersama.
                                </p>
                            </div>

                            <div class="mb-4">
                                <h2 class="h5 fw-bold mb-2">4. Pengembalian dan Denda</h2>
                                <p class="text-muted mb-0">
                                    Mobil wajib dikembalikan sesuai tanggal yang disepakati. Keterlambatan pengembalian
                                    akan dikenakan denda sesuai tarif yang berlaku di pengaturan aplikasi.
                                </p>
                            </div>

                            <div class="mb-4">
                                <h2 class="h5 fw-bold mb-2">5. Tanggung Jawab Penyewa</h2>
                                <p class="text-muted mb-0">
                                    Penyewa bertanggung jawab atas kondisi mobil selama masa sewa, termasuk
                                    kerusakan yang disebabkan kelalaian penyewa.
                                </p>
                            </div>

                            <div class="mb-0">
                                <h2 class="h5 fw-bold mb-2">6. Lain-lain</h2>
                                <p class="text-muted mb-0">
                                    Ketentuan ini dapat berubah sewaktu-waktu. Pertanyaan lebih lanjut dapat
                                    diajukan melalui halaman <a href="{{ url('kontak') }}">kontak</a>.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
