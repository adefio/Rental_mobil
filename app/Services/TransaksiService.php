<?php

namespace App\Services;

use App\Contracts\Repositories\MobilRepositoryInterface;
use App\Contracts\Repositories\PenggunaRepositoryInterface;
use App\Contracts\Repositories\TransaksiRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TransaksiService
{
    public function __construct(
        protected TransaksiRepositoryInterface $repository,
        protected PenggunaRepositoryInterface $penggunaRepository,
        protected MobilRepositoryInterface $mobilRepository
    ) {
    }

    public function paginatedData(): array
    {
        $transaksi = $this->repository->paginate(10);

        return [
            'transaksi' => $transaksi,
            'columns' => $this->columns(),
            'pagination' => $this->paginationMeta($transaksi),
        ];
    }

    public function createData(): array
    {
        return [
            'list_pengguna' => $this->penggunaRepository->pluckPengguna(),
            'list_mobil' => $this->mobilRepository->pluckMobil(),
            'mobil_prices' => $this->mobilRepository->pluckMobil('harga_sewa', 'id'),
        ];
    }

    public function editData(int $id): array
    {
        $data = $this->createData();
        $data['transaksi'] = $this->repository->findOrFail($id);

        return $data;
    }

    public function showData(int $id): array
    {
        $transaksi = $this->repository->findOrFail($id);
        $transaksi->load('maintenance');

        return ['transaksi' => $transaksi];
    }

    public function konfirmasiBayar(int $id)
    {
        $transaksi = $this->repository->findOrFail($id);

        if ($transaksi->status_pembayaran !== 'pending') {
            throw new \DomainException('Hanya transaksi berstatus pending yang dapat dikonfirmasi.');
        }

        return $this->repository->update($id, ['status_pembayaran' => 'lunas']);
    }

    public function laporanData(): Collection
    {
        return $this->repository->all();
    }

    public function store(array $data)
    {
        $penggunaId = $this->resolvePenggunaId($data);

        $this->cekTumpangTindih($data);

        $transaksi = $this->repository->create([
            'pengguna_id' => $penggunaId,
            'mobil_id' => $data['mobil_id'],
            'tanggal_pemesanan' => $data['tanggal_pemesanan'],
            'tanggal_mulai' => $data['tanggal_mulai'],
            'tanggal_selesai' => $data['tanggal_selesai'],
            'total_harga' => $this->hitungTotal($data),
            'status_pembayaran' => $data['status_pembayaran'],
        ]);

        $this->syncStatusMobil($data['mobil_id'], $data['status_pembayaran']);

        return $transaksi;
    }

    public function update(int $id, array $data)
    {
        $transaksi = $this->repository->findOrFail($id);
        $statusLama = $transaksi->status_pembayaran;

        $this->cekTumpangTindih($data, $id);

        $transaksi = $this->repository->update($id, array_merge($data, [
            'total_harga' => $this->hitungTotal($data),
        ]));

        $this->syncStatusMobilOnUpdate($transaksi, $statusLama, $data['status_pembayaran']);

        return $transaksi;
    }

    public function delete(int $id): bool
    {
        $transaksi = $this->repository->findOrFail($id);

        $deleted = $this->repository->delete($id);

        if ($deleted && $transaksi->status_pembayaran !== 'batal') {
            $this->mobilRepository->update($transaksi->mobil_id, ['status' => 'tersedia']);
        }

        return $deleted;
    }

    protected function resolvePenggunaId(array $data): int
    {
        if (! empty($data['pengguna_id'])) {
            return (int) $data['pengguna_id'];
        }

        $pengguna = $this->penggunaRepository->create([
            'user_id' => null,
            'nama' => $data['nama_baru'],
            'email' => $data['email_baru'] ?? null,
            'password' => null,
            'role' => 'pelanggan',
            'no_telepon' => $data['no_telepon_baru'] ?? null,
            'alamat' => $data['alamat_baru'] ?? null,
        ]);

        return $pengguna->id;
    }

    protected function syncStatusMobil(int $mobilId, string $statusPembayaran): void
    {
        $this->mobilRepository->update($mobilId, [
            'status' => in_array($statusPembayaran, ['batal', 'selesai'], true) ? 'tersedia' : 'disewa',
        ]);
    }

    protected function syncStatusMobilOnUpdate($transaksi, string $statusLama, string $statusBaru): void
    {
        $mobilDuluBebas = in_array($statusLama, ['batal', 'selesai'], true);
        $mobilSekarangBebas = in_array($statusBaru, ['batal', 'selesai'], true);

        if ($mobilDuluBebas !== $mobilSekarangBebas) {
            $this->mobilRepository->update($transaksi->mobil_id, [
                'status' => $mobilSekarangBebas ? 'tersedia' : 'disewa',
            ]);
        }
    }

    protected function cekTumpangTindih(array $data, int $kecualiTransaksiId = null): void
    {
        if ($this->repository->adaTabrakanTanggal(
            (int) $data['mobil_id'],
            $data['tanggal_mulai'],
            $data['tanggal_selesai'],
            $kecualiTransaksiId
        )) {
            throw new \DomainException('Mobil sudah dibooking pada rentang tanggal tersebut. Silakan pilih tanggal atau mobil lain.');
        }
    }

    protected function hitungTotal(array $data): float
    {
        $mobil = $this->mobilRepository->find((int) $data['mobil_id']);

        if (!$mobil) {
            return (float) $data['total_harga'];
        }

        $mulai = Carbon::parse($data['tanggal_mulai']);
        $selesai = Carbon::parse($data['tanggal_selesai']);
        $jumlahHari = $mulai->diffInDays($selesai) + 1;

        return (float) $mobil->harga_sewa * max(1, $jumlahHari);
    }

    public function terbaru(int $limit = 5)
    {
        return $this->repository->terbaru($limit);
    }

    protected function columns(): array
    {
        return [
            ['key' => 'id', 'label' => 'ID'],
            ['key' => 'pengguna', 'label' => 'Pengguna', 'accessor' => ['nama']],
            ['key' => 'mobil', 'label' => 'Mobil', 'accessor' => ['nama_mobil']],
            ['key' => 'tanggal_mulai', 'label' => 'Mulai', 'type' => 'date'],
            ['key' => 'tanggal_selesai', 'label' => 'Selesai', 'type' => 'date'],
            ['key' => 'total_harga', 'label' => 'Total', 'type' => 'currency'],
            ['key' => 'status_pembayaran', 'label' => 'Status', 'type' => 'badge', 'badgeMap' => [
                ['value' => 'lunas', 'label' => 'Lunas', 'class' => 'bg-success'],
                ['value' => 'selesai', 'label' => 'Selesai', 'class' => 'bg-info text-dark'],
                ['value' => 'pending', 'label' => 'Pending', 'class' => 'bg-warning text-dark'],
                ['value' => 'batal', 'label' => 'Batal', 'class' => 'bg-danger'],
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
