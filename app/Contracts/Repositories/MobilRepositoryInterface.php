<?php

namespace App\Contracts\Repositories;

use Illuminate\Support\Collection;

interface MobilRepositoryInterface extends RepositoryInterface
{
    public function pluckMobil(string $value = 'nama_mobil', string $key = 'id'): Collection;

    public function palingPopuler(int $limit = 5);

    public function tersedia(int $limit = null): Collection;

    public function katalog(string $search = null): Collection;
}
