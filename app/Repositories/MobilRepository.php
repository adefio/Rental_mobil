<?php

namespace App\Repositories;

use App\Contracts\Repositories\MobilRepositoryInterface;
use App\Models\Mobil;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class MobilRepository extends EloquentRepository implements MobilRepositoryInterface
{
    protected function model(): string
    {
        return Mobil::class;
    }

    protected function withRelations(): array
    {
        return ['transaksi'];
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return $this->query()
            ->with($this->withRelations())
            ->orderBy('id', 'desc')
            ->paginate($perPage);
    }

    public function pluckMobil(string $value = 'nama_mobil', string $key = 'id'): \Illuminate\Support\Collection
    {
        return $this->query()->pluck($value, $key);
    }

    public function palingPopuler(int $limit = 5)
    {
        return $this->query()
            ->withCount('transaksi')
            ->orderBy('transaksi_count', 'desc')
            ->limit($limit)
            ->get();
    }

    public function tersedia(int $limit = null): \Illuminate\Support\Collection
    {
        $query = $this->query()->where('status', 'tersedia');

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    public function terbaru(int $limit = 4): \Illuminate\Support\Collection
    {
        return $this->query()
            ->where('status', '!=', 'maintenance')
            ->orderBy('id', 'desc')
            ->limit($limit)
            ->get();
    }

    public function katalog(string $search = null): \Illuminate\Support\Collection
    {
        return $this->query()
            ->where('status', '!=', 'maintenance')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_mobil', 'like', "%{$search}%")
                        ->orWhere('merk', 'like', "%{$search}%")
                        ->orWhere('tahun', 'like', "%{$search}%");
                });
            })
            ->orderBy('harga_sewa', 'asc')
            ->get();
    }
}
