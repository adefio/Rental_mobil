<?php

namespace App\Contracts\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PesanRepositoryInterface extends RepositoryInterface
{
    public function paginateBaru(int $perPage = 10): LengthAwarePaginator;

    public function jumlahBelumDibaca(): int;
}
