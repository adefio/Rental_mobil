<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;
    protected $table = 'mobil';

    protected $fillable = [
        'nama_mobil',
        'merk',
        'tahun',
        'harga_sewa',
        'deskripsi',
        'status',
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'mobil_id');
    }
}
