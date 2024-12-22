<?php

use App\Http\Controllers\MobilController;
use App\Http\Controllers\PenggunaController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Menambahkan middleware auth untuk memastikan user yang sudah login dapat mengakses route berikut
Route::middleware(['auth'])->group(function () {

    // Route untuk Pengguna
    Route::resource('pengguna', PenggunaController::class);
    Route::get('pengguna/laporan/cetak', [PenggunaController::class, 'laporan']);
    Route::delete('pengguna/{id}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');

    // Route untuk Mobil
    Route::resource('mobil', MobilController::class);  // Menggunakan "mobil" sebagai nama route
    Route::get('mobil/laporan/cetak', [MobilController::class, 'laporan']);
    Route::delete('mobil/{id}', [MobilController::class, 'destroy'])->name('mobil.destroy');  // Mengubah nama route

    Route::resource('transaksi', TransaksiController::class);  // Menggunakan "mobil" sebagai nama route
    Route::get('transaksi/laporan/cetak', [TransaksiController::class, 'laporan']);
    Route::delete('transaksi/{id}', [TransaksiController::class, 'destroy'])->name('mobil.destroy');  // Mengubah nama route

});
