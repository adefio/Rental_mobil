<?php

namespace App\Models;

use App\Traits\SequentialId;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use SequentialId;

    protected $fillable = [
        'key',
        'value',
    ];
}
