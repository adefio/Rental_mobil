<?php

namespace App\Services;

use App\Contracts\Repositories\PenggunaRepositoryInterface;
use Illuminate\Support\Collection;

class PenggunaService
{
    public function __construct(protected PenggunaRepositoryInterface $repository)
    {
    }

    public function paginatedData(): array
    {
        $pengguna = $this->repository->paginatePelanggan(10);

        return [
            'pengguna' => $pengguna,
            'columns' => $this->columns(),
            'pagination' => $this->paginationMeta($pengguna),
        ];
    }

    public function laporanData(): Collection
    {
        return $this->repository->allPelanggan();
    }

    public function store(array $data)
    {
        $data['password'] = bcrypt($data['password']);

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

    protected function columns(): array
    {
        return [
            ['key' => 'id', 'label' => 'ID'],
            ['key' => 'nama', 'label' => 'Nama'],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'no_telepon', 'label' => 'No. Telepon'],
            ['key' => 'alamat', 'label' => 'Alamat'],
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
