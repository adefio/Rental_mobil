<?php

namespace App\Repositories;

use App\Contracts\Repositories\PesanRepositoryInterface;
use App\Models\Pesan;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PesanRepository extends EloquentRepository implements PesanRepositoryInterface
{
    protected function model(): string
    {
        return Pesan::class;
    }

    protected function withRelations(): array
    {
        return [];
    }

    public function paginateBaru(int $perPage = 10): LengthAwarePaginator
    {
        return $this->query()->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function jumlahBelumDibaca(): int
    {
        return $this->query()->where('dibaca', false)->count();
    }
}
