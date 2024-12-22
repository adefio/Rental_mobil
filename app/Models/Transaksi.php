<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    // Menentukan nama tabel jika berbeda dari default (bentuk jamak dari nama model)
    protected $table = 'transaksi';

    // Kolom yang boleh diisi melalui mass assignment
    protected $fillable = [
        'pengguna_id',
        'mobil_id',
        'tanggal_pemesanan',
        'tanggal_mulai',
        'tanggal_selesai',
        'total_harga',
        'status_pembayaran',
    ];

    /**
     * Relasi ke model Pengguna
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    /**
     * Relasi ke model Mobil
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mobil()
    {
        return $this->belongsTo(Mobil::class, 'mobil_id');
    }

    /**
     * Relasi ke model Maintenance (satu transaksi mungkin memiliki satu maintenance)
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function maintenance()
    {
        return $this->hasOne(Pengembalian::class, 'transaksi_id');
    }
}
