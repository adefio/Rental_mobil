<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SequentialId;

class Pesan extends Model
{
    use HasFactory, SequentialId;

    protected $table = 'pesan';

    protected $fillable = [
        'nama',
        'email',
        'no_telepon',
        'subjek',
        'pesan',
        'dibaca',
    ];

    protected $casts = [
        'dibaca' => 'boolean',
    ];
}
