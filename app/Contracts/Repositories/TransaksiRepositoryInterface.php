<?php

namespace App\Contracts\Repositories;

interface TransaksiRepositoryInterface extends RepositoryInterface
{
    public function pluckTransaksi(string $value = 'id', string $key = 'id'): \Illuminate\Support\Collection;

    public function terbaru(int $limit = 5);

    public function byPengguna(int $penggunaId);

    public function pendapatanLunasGrouped(string $since, string $dateFormat): array;
}
