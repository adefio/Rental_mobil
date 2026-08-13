<?php

namespace App\Services;

use App\Contracts\Repositories\MobilRepositoryInterface;
use Illuminate\Support\Collection;

class MobilService
{
    public function __construct(protected MobilRepositoryInterface $repository)
    {
    }

    public function paginatedData(): array
    {
        $mobil = $this->repository->paginate(10);

        return [
            'mobil' => $mobil,
            'columns' => $this->columns(),
            'pagination' => $this->paginationMeta($mobil),
        ];
    }

    public function laporanData(): Collection
    {
        return $this->repository->all();
    }

    public function store(array $data)
    {
        return $this->repository->create($data);
    }

    public function findForEdit(int $id)
    {
        return $this->repository->findOrFail($id);
    }

    public function update(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }

    public function palingPopuler(int $limit = 5)
    {
        return $this->repository->palingPopuler($limit);
    }

    protected function columns(): array
    {
        return [
            ['key' => 'id', 'label' => 'ID'],
            ['key' => 'gambar', 'label' => 'Gambar', 'type' => 'image'],
            ['key' => 'nama_mobil', 'label' => 'Nama Mobil'],
            ['key' => 'merk', 'label' => 'Merk'],
            ['key' => 'tahun', 'label' => 'Tahun'],
            ['key' => 'harga_sewa', 'label' => 'Harga Sewa', 'type' => 'currency'],
            ['key' => 'status', 'label' => 'Status', 'type' => 'badge', 'badgeMap' => [
                ['value' => 'tersedia', 'label' => 'Tersedia', 'class' => 'bg-success'],
                ['value' => 'disewa', 'label' => 'Disewa', 'class' => 'bg-warning text-dark'],
                ['value' => 'maintenance', 'label' => 'Maintenance', 'class' => 'bg-danger'],
            ]],
        ];
    }

    protected function paginationMeta($paginator): array
    {
        return [
            'total' => $paginator->total(),
            'per_page' => $paginator->perPage(),
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'next_url' => $paginator->nextPageUrl(),
            'prev_url' => $paginator->previousPageUrl(),
        ];
    }
}
