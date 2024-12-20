<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    use HasFactory;
    protected $table = 'pengguna';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'no_telepon',
        'alamat',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'pengguna_id');
    }
}
