<?php

namespace App\Repositories;

use App\Contracts\Repositories\PengembalianRepositoryInterface;
use App\Models\Pengembalian;
use App\Models\Transaksi;

class PengembalianRepository extends EloquentRepository implements PengembalianRepositoryInterface
{
    protected function model(): string
    {
        return Pengembalian::class;
    }

    protected function withRelations(): array
    {
        return ['transaksi.pengguna', 'transaksi.mobil'];
    }

    public function pluckTransaksi(string $value = 'id', string $key = 'id'): \Illuminate\Support\Collection
    {
        return Transaksi::query()->pluck($value, $key);
    }
}
