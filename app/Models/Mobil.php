<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SequentialId;

class Mobil extends Model
{
    use HasFactory, SequentialId;
    protected $table = 'mobil';

    protected $fillable = [
        'nama_mobil',
        'merk',
        'tahun',
        'harga_sewa',
        'deskripsi',
        'status',
        'gambar',
    ];

    protected $casts = [
        'gambar' => 'array',
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'mobil_id');
    }
}
