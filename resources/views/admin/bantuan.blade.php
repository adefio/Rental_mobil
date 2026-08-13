@extends('layouts.admin')

@section('title', 'Bantuan & Panduan')

@section('content')
    <div class="admin-page-header d-flex flex-wrap align-items-end justify-content-between gap-3">
        <div>
            <h1 class="admin-page-title mb-1">Bantuan & Panduan</h1>
            <p class="admin-page-sub mb-0">Panduan singkat mengelola data rental mobil beserta jawaban atas pertanyaan umum.</p>
        </div>
        <span class="badge badge-status bg-info-subtle text-info"><x-icon name="book" class="icon-sm" /> Panduan Admin</span>
    </div>

    <div class="guide-layout">
        <aside class="guide-nav d-none d-xl-block">
            <nav aria-label="Daftar isi panduan">
                <ul class="guide-nav-list">
                    <li><a href="#mulai">Mulai Cepat</a></li>
                    <li><a href="#kelola-mobil">Kelola Data Mobil</a></li>
                    <li><a href="#kelola-pengguna">Kelola Data Pengguna</a></li>
                    <li><a href="#kelola-transaksi">Transaksi & Pengembalian</a></li>
                    <li><a href="#laporan">Melihat Laporan</a></li>
                    <li><a href="#pengaturan">Pengaturan Aplikasi</a></li>
                    <li><a href="#faq">Pertanyaan Umum (FAQ)</a></li>
                </ul>
            </nav>
        </aside>

        <div class="guide-content">
            <section class="card page-card mb-4" id="mulai">
                <div class="card-header d-flex align-items-center gap-2">
                    <span class="profile-section-icon"><x-icon name="zap" class="icon-sm" /></span>
                    <span>Mulai Cepat</span>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted">Ikuti 4 langkah berikut agar siap melayani pelanggan:</p>
                    <ol class="guide-steps">
                        <li>
                            <span class="guide-step-num">1</span>
                            <div>
                                <strong>Tambahkan data mobil</strong>
                                <p class="mb-0">Masuk ke menu <em>Data Mobil</em> lalu klik <span class="badge bg-primary">Tambah Mobil</span> untuk mengisi armada beserta harga sewanya.</p>
                            </div>
                        </li>
                        <li>
                            <span class="guide-step-num">2</span>
                            <div>
                                <strong>Daftarkan pelanggan</strong>
                                <p class="mb-0">Simpan data pelanggan di menu <em>Data Pengguna</em> agar mudah memilih pelanggan saat menerima pesanan.</p>
                            </div>
                        </li>
                        <li>
                            <span class="guide-step-num">3</span>
                            <div>
                                <strong>Terima pesanan</strong>
                                <p class="mb-0">Di menu <em>Data Transaksi</em>, klik <span class="badge bg-primary">Terima Pesanan</span> dan pilih mobil serta jadwal penyewaan.</p>
                            </div>
                        </li>
                        <li>
                            <span class="guide-step-num">4</span>
                            <div>
                                <strong>Catat pengembalian</strong>
                                <p class="mb-0">Saat mobil dikembalikan, catat di menu <em>Data Pengembalian</em>. Denda keterlambatan dihitung otomatis sesuai tarif.</p>
                            </div>
                        </li>
                    </ol>
                </div>
            </section>

            <section class="card page-card mb-4" id="kelola-mobil">
                <div class="card-header d-flex align-items-center gap-2">
                    <span class="profile-section-icon"><x-icon name="car" class="icon-sm" /></span>
                    <span>Kelola Data Mobil</span>
                </div>
                <div class="card-body p-4">
                    <ul class="guide-tips">
                        <li>Gunakan menu <em>Edit</em> untuk mengubah harga atau status ketersediaan mobil.</li>
                        <li>Status <span class="badge bg-success">Tersedia</span> dan <span class="badge bg-danger">Disewa</span> membantu pelanggan memilih armada di situs publik.</li>
                        <li>Saat mobil dihapus, gambar armada ikut terhapus dan tidak bisa dikembalikan.</li>
                    </ul>
                </div>
            </section>

            <section class="card page-card mb-4" id="kelola-pengguna">
                <div class="card-header d-flex align-items-center gap-2">
                    <span class="profile-section-icon"><x-icon name="users" class="icon-sm" /></span>
                    <span>Kelola Data Pengguna</span>
                </div>
                <div class="card-body p-4">
                    <ul class="guide-tips">
                        <li>Pengguna terbagi menjadi <strong>administrator</strong> dan <strong>pelanggan</strong>.</li>
                        <li>Akun administrator dan data pelanggan yang sedang bertransaksi tidak dapat dihapus.</li>
                        <li>Data pelanggan baru juga bisa dibuat otomatis saat menerima pesanan dari pelanggan baru.</li>
                    </ul>
                </div>
            </section>

            <section class="card page-card mb-4" id="kelola-transaksi">
                <div class="card-header d-flex align-items-center gap-2">
                    <span class="profile-section-icon"><x-icon name="clipboard" class="icon-sm" /></span>
                    <span>Transaksi & Pengembalian</span>
                </div>
                <div class="card-body p-4">
                    <ul class="guide-tips">
                        <li>Status pembayaran: <span class="badge bg-warning text-dark">Pending</span>, <span class="badge bg-success">Lunas</span>, dan <span class="badge bg-danger">Batal</span>.</li>
                        <li>Harga sewa dihitung dari tarif harian dikali lama penyewaan dan bisa disesuaikan manual.</li>
                        <li>Pengembalian mencatat tanggal kembali serta kondisi mobil; denda dihitung dari keterlambatan.</li>
                        <li>Dashboard hanya menghitung pendapatan dari transaksi berstatus <strong>Lunas</strong>.</li>
                    </ul>
                </div>
            </section>

            <section class="card page-card mb-4" id="laporan">
                <div class="card-header d-flex align-items-center gap-2">
                    <span class="profile-section-icon"><x-icon name="file-text" class="icon-sm" /></span>
                    <span>Melihat Laporan</span>
                </div>
                <div class="card-body p-4">
                    <ul class="guide-tips">
                        <li>Menu <em>Laporan</em> di sidebar menampilkan ringkasan data tiap modul.</li>
                        <li>Gunakan tombol <span class="badge bg-primary">Cetak</span> untuk mencetak atau menyimpan laporan sebagai PDF.</li>
                        <li>Pastikan hasil cetak sesuai ukuran kertas di pengaturan printer Anda.</li>
                    </ul>
                </div>
            </section>

            <section class="card page-card mb-4" id="pengaturan">
                <div class="card-header d-flex align-items-center gap-2">
                    <span class="profile-section-icon"><x-icon name="settings" class="icon-sm" /></span>
                    <span>Pengaturan Aplikasi</span>
                </div>
                <div class="card-body p-4">
                    <ul class="guide-tips">
                        <li>Ubah nama aplikasi, slogan, kontak, alamat, dan jam operasional di menu <em>Pengaturan Aplikasi</em>.</li>
                        <li>Tarif denda per hari digunakan untuk menghitung denda keterlambatan pengembalian.</li>
                        <li>Perubahan langsung tampil di situs publik tanpa perlu instalasi ulang.</li>
                    </ul>
                </div>
            </section>

            <section class="card page-card mb-4" id="faq">
                <div class="card-header d-flex align-items-center gap-2">
                    <span class="profile-section-icon"><x-icon name="help-circle" class="icon-sm" /></span>
                    <span>Pertanyaan Umum (FAQ)</span>
                </div>
                <div class="card-body p-4">
                    <div class="accordion guide-accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq1" aria-expanded="true" aria-controls="faq1">
                                    Bagaimana jika lupa kata sandi akun admin?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Gunakan tautan <em>Lupa Kata Sandi</em> di halaman login untuk mengatur ulang kata sandi melalui email. Jika belum terkirim, periksa folder spam atau hubungi pengelola sistem.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
                                    Apakah data yang dihapus bisa dipulihkan?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Data yang dihapus tidak bisa dipulihkan. Sebaiknya pastikan kembali sebelum menghapus, dan lakukan pencatatan manual jika diperlukan.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
                                    Mengapa grafik di dashboard tidak muncul?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Muat ulang halaman dengan menekan <kbd>Ctrl</kbd> + <kbd>F5</kbd> atau buka melalui mode penyamaran untuk menyegarkan data yang tersimpan di peramban.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq4" aria-expanded="false" aria-controls="faq4">
                                    Di mana saya melihat riwayat perubahan data?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Buka menu <em>Log Aktivitas</em>. Semua aktivitas masuk, keluar, serta penambahan/perubahan/penghapusan data tercatat beserta waktu dan penggunanya.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
