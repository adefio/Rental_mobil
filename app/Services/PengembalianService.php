<?php

namespace App\Services;

use App\Contracts\Repositories\MobilRepositoryInterface;
use App\Contracts\Repositories\PengembalianRepositoryInterface;
use App\Contracts\Repositories\TransaksiRepositoryInterface;
use Illuminate\Support\Collection;

class PengembalianService
{
    public function __construct(
        protected PengembalianRepositoryInterface $repository,
        protected TransaksiRepositoryInterface $transaksiRepository,
        protected MobilRepositoryInterface $mobilRepository
    ) {
    }

    public function paginatedData(): array
    {
        $pengembalian = $this->repository->paginate(10);

        return [
            'pengembalian' => $pengembalian,
            'columns' => $this->columns(),
            'pagination' => $this->paginationMeta($pengembalian),
        ];
    }

    public function createData(): array
    {
        return [
            'list_transaksi' => $this->repository->pluckTransaksi(),
        ];
    }

    public function editData(int $id): array
    {
        $data = $this->createData();
        $data['pengembalian'] = $this->repository->findOrFail($id);

        return $data;
    }

    public function laporanData(): Collection
    {
        return $this->repository->all();
    }

    public function store(array $data)
    {
        $data = $this->resolveDenda($data);

        $pengembalian = $this->repository->create($data);

        $this->tutupTransaksi((int) $data['transaksi_id']);

        return $pengembalian;
    }

    public function update(int $id, array $data)
    {
        $pengembalian = $this->repository->findOrFail($id);

        $data = $this->resolveDenda($data);

        $pengembalian = $this->repository->update($id, $data);

        if ((int) $data['transaksi_id'] !== (int) $pengembalian->transaksi_id) {
            $this->tutupTransaksi((int) $data['transaksi_id']);
        }

        return $pengembalian;
    }

    public function delete(int $id): bool
    {
        $pengembalian = $this->repository->findOrFail($id);

        $deleted = $this->repository->delete($id);

        if ($deleted) {
            $this->bukaKembaliTransaksi((int) $pengembalian->transaksi_id);
        }

        return $deleted;
    }

    protected function tutupTransaksi(int $transaksiId): void
    {
        $transaksi = $this->transaksiRepository->findOrFail($transaksiId);

        $this->transaksiRepository->update($transaksiId, ['status_pembayaran' => 'selesai']);
        $this->mobilRepository->update($transaksi->mobil_id, ['status' => 'tersedia']);
    }

    protected function bukaKembaliTransaksi(int $transaksiId): void
    {
        $transaksi = $this->transaksiRepository->findOrFail($transaksiId);

        $this->transaksiRepository->update($transaksiId, ['status_pembayaran' => 'pending']);
        $this->mobilRepository->update($transaksi->mobil_id, ['status' => 'disewa']);
    }

    protected function resolveDenda(array $data): array
    {
        if (!empty($data['denda_telat'])) {
            return $data;
        }

        $transaksi = $this->transaksiRepository->findOrFail($data['transaksi_id']);
        $data['denda_telat'] = (new \App\Models\Pengembalian())
            ->hitungDendaTelat($transaksi->tanggal_selesai, $data['tanggal_pengembalian']);

        return $data;
    }

    protected function columns(): array
    {
        return [
            ['key' => 'id', 'label' => 'ID'],
            ['key' => 'transaksi', 'label' => 'ID Transaksi', 'accessor' => ['id']],
            ['key' => 'transaksi', 'label' => 'Pengguna', 'accessor' => ['transaksi', 'pengguna', 'nama']],
            ['key' => 'transaksi', 'label' => 'Mobil', 'accessor' => ['transaksi', 'mobil', 'nama_mobil']],
            ['key' => 'tanggal_pengembalian', 'label' => 'Tgl Kembali', 'type' => 'date'],
            ['key' => 'denda_telat', 'label' => 'Denda', 'type' => 'currency'],
            ['key' => 'biaya_kerusakan', 'label' => 'Kerusakan', 'type' => 'currency'],
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
