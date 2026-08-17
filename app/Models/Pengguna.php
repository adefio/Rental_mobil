<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SequentialId;

class Pengguna extends Model
{
    use HasFactory, SequentialId;
    protected $table = 'pengguna';

    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'password',
        'role',
        'no_telepon',
        'alamat',
        'foto_profil',
    ];

    protected $hidden = [
        'password',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'pengguna_id');
    }
}
