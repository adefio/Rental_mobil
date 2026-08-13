<?php

namespace App\Contracts\Repositories;

interface PengembalianRepositoryInterface extends RepositoryInterface
{
    public function pluckTransaksi(string $value = 'id', string $key = 'id'): \Illuminate\Support\Collection;
}
