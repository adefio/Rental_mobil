<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PublicController::class, 'home'])->name('landing');

Route::get('/sewa-mobil', [PublicController::class, 'katalog'])->name('katalog');
Route::get('/sewa-mobil/{id}', [PublicController::class, 'detail'])->name('mobil.detail');

Route::get('/tentang-kami', [PublicController::class, 'tentang'])->name('tentang');
Route::get('/kontak', [PublicController::class, 'kontak'])->name('kontak');
Route::post('/kontak', [PublicController::class, 'kirimPesan'])->name('kontak.kirim');
Route::get('/kebijakan-privasi', [PublicController::class, 'kebijakanPrivasi'])->name('kebijakan.privasi');
Route::get('/syarat-ketentuan', [PublicController::class, 'syaratKetentuan'])->name('syarat.ketentuan');

Route::middleware(['auth', 'user'])->group(function () {
    Route::post('/sewa-mobil/{id}/booking', [PublicController::class, 'booking'])->name('booking.store');
    Route::get('/pesanan-saya', [PublicController::class, 'pesananSaya'])->name('pesanan.saya');
    Route::post('/pesanan-saya/{id}/batal', [PublicController::class, 'batalkanPesanan'])->name('pesanan.batal');
    Route::post('/pesanan-saya/{id}/konfirmasi', [PublicController::class, 'konfirmasiPembayaran'])->name('pesanan.konfirmasi');
    Route::get('/pengaturan-akun', [PublicController::class, 'pengaturanAkun'])->name('pengaturan.akun');
    Route::put('/pengaturan-akun', [PublicController::class, 'updatePengaturanAkun'])->name('pengaturan.akun.update');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home')
    ->middleware(['auth', 'admin']);

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('profil', [HomeController::class, 'profil'])->name('admin.profil');
    Route::put('profil', [HomeController::class, 'updateProfil'])->name('admin.profil.update');

    Route::resource('pengguna', PenggunaController::class)->except(['show']);
    Route::get('pengguna/laporan/cetak', [PenggunaController::class, 'laporan']);

    Route::resource('mobil', MobilController::class)->except(['show']);
    Route::get('mobil/laporan/cetak', [MobilController::class, 'laporan']);

    Route::resource('transaksi', TransaksiController::class);
    Route::post('transaksi/{id}/konfirmasi-bayar', [TransaksiController::class, 'konfirmasiBayar']);
    Route::get('transaksi/laporan/cetak', [TransaksiController::class, 'laporan']);

    Route::resource('pengembalian', PengembalianController::class)->except(['show']);
    Route::get('pengembalian/laporan/cetak', [PengembalianController::class, 'laporan']);

    Route::get('pesan', [PesanController::class, 'index'])->name('admin.pesan');
    Route::post('pesan/{id}/tandai', [PesanController::class, 'tandaiDibaca'])->name('admin.pesan.tandai');
    Route::delete('pesan/{id}', [PesanController::class, 'destroy'])->name('admin.pesan.destroy');

    Route::get('pengaturan', [HomeController::class, 'pengaturan'])->name('admin.pengaturan');
    Route::put('pengaturan', [HomeController::class, 'updatePengaturan'])->name('admin.pengaturan.update');

    Route::get('bantuan', [HomeController::class, 'bantuan'])->name('admin.bantuan');
});
