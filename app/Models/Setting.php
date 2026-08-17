<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SequentialId;

class Setting extends Model
{
    use SequentialId;
    protected $fillable = [
        'key',
        'value',
    ];
}
