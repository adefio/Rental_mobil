<?php

namespace App\Services;

use App\Contracts\Repositories\PesanRepositoryInterface;

class PesanService
{
    public function __construct(protected PesanRepositoryInterface $repository)
    {
    }

    public function paginatedData(): array
    {
        $pesan = $this->repository->paginateBaru(15);

        return [
            'pesan' => $pesan,
            'jumlah_belum_dibaca' => $this->repository->jumlahBelumDibaca(),
        ];
    }

    public function store(array $data)
    {
        return $this->repository->create([
            'nama' => $data['nama'],
            'email' => $data['email'],
            'no_telepon' => $data['no_telepon'] ?? null,
            'subjek' => $data['subjek'] ?? null,
            'pesan' => $data['pesan'],
            'dibaca' => false,
        ]);
    }

    public function tandaiDibaca(int $id, bool $dibaca = true)
    {
        return $this->repository->update($id, ['dibaca' => $dibaca]);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
