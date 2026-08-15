<?php

namespace App\Repositories;

use App\Contracts\Repositories\PenggunaRepositoryInterface;
use App\Models\Pengguna;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PenggunaRepository extends EloquentRepository implements PenggunaRepositoryInterface
{
    protected function model(): string
    {
        return Pengguna::class;
    }

    protected function withRelations(): array
    {
        return ['transaksi'];
    }

    public function pluckPengguna(string $value = 'nama', string $key = 'id'): \Illuminate\Support\Collection
    {
        return $this->query()->pluck($value, $key);
    }

    public function findByUserId(int $userId)
    {
        return $this->query()->where('user_id', $userId)->first();
    }

    public function findByEmail(string $email)
    {
        return $this->query()->where('email', $email)->first();
    }

    public function paginatePelanggan(int $perPage = 10): LengthAwarePaginator
    {
        return $this->query()
            ->with($this->withRelations())
            ->where('role', 'pelanggan')
            ->paginate($perPage);
    }

    public function allPelanggan(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->query()
            ->with($this->withRelations())
            ->where('role', 'pelanggan')
            ->get();
    }
}
