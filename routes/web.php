<?php

use App\Http\Controllers\MobilController;
use App\Http\Controllers\PengembalianController;
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

Route::middleware(['auth'])->group(function () {

    Route::resource('pengguna', PenggunaController::class);
    Route::get('pengguna/laporan/cetak', [PenggunaController::class, 'laporan']);
    Route::delete('pengguna/{id}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');

    Route::resource('mobil', MobilController::class);
    Route::get('mobil/laporan/cetak', [MobilController::class, 'laporan']);
    Route::delete('mobil/{id}', [MobilController::class, 'destroy'])->name('mobil.destroy');

    Route::resource('transaksi', TransaksiController::class);
    Route::get('transaksi/laporan/cetak', [TransaksiController::class, 'laporan']);
    Route::delete('transaksi/{id}', [TransaksiController::class, 'destroy'])->name('mobil.destroy');

    Route::resource('pengembalian', PengembalianController::class);
    Route::get('pengembalian/laporan/cetak', [PengembalianController::class, 'laporan']);
    Route::delete('pengembalian/{id}', [PengembalianController::class, 'destroy'])->name('mobil.destroy');
});
