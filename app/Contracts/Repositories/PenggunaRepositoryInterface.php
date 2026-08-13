<?php

namespace App\Contracts\Repositories;

interface PenggunaRepositoryInterface extends RepositoryInterface
{
    public function pluckPengguna(string $value = 'nama', string $key = 'id'): \Illuminate\Support\Collection;

    public function findByUserId(int $userId);

    public function paginatePelanggan(int $perPage = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator;

    public function allPelanggan(): \Illuminate\Database\Eloquent\Collection;
}
