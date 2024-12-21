<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pengembalian extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaksi_id',
        'denda_telat',
        'biaya_kerusakan',
        'deskripsi_kerusakan',
        'tanggal_pengembalian',
    ];

    // Relasi dengan model Transaksi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    /**
     * Fungsi untuk menghitung denda keterlambatan.
     * 
     * @param string $tanggal_seharusnya_kembali
     * @param string $tanggal_pengembalian
     * @return float
     */
    public function hitungDendaTelat($tanggal_seharusnya_kembali, $tanggal_pengembalian)
    {
        $tarif_denda_per_hari = 50000; // Tarif denda per hari, bisa disesuaikan dengan kebutuhan

        // Menghitung selisih hari antara tanggal pengembalian dan tanggal seharusnya kembali
        $tanggal_seharusnya_kembali = Carbon::parse($tanggal_seharusnya_kembali);
        $tanggal_pengembalian = Carbon::parse($tanggal_pengembalian);

        // Jika tanggal pengembalian lebih dari tanggal seharusnya kembali, hitung denda
        if ($tanggal_pengembalian->gt($tanggal_seharusnya_kembali)) {
            $selisih_hari = $tanggal_seharusnya_kembali->diffInDays($tanggal_pengembalian);
            return $selisih_hari * $tarif_denda_per_hari;
        }

        return 0; // Tidak ada denda jika tidak terlambat
    }

    /**
     * Fungsi untuk menghitung total denda (denda keterlambatan + biaya kerusakan)
     * 
     * @return float
     */
    public function hitungTotalDenda()
    {
        return $this->denda_telat + ($this->biaya_kerusakan ?? 0);
    }
}
