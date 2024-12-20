<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $fillable = [
        'pengguna_id',
        'mobil_id',
        'tanggal_pemesanan',
        'tanggal_mulai',
        'tanggal_selesai',
        'total_harga',
        'status_pembayaran',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function mobil()
    {
        return $this->belongsTo(Mobil::class, 'mobil_id');
    }

    public function maintenance()
    {
        return $this->hasOne(Maintenance::class, 'transaksi_id');
    }

    public function ulasan()
    {
        return $this->hasOne(Ulasan::class, 'transaksi_id');
    }
}
