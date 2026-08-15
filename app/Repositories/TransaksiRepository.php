<?php

namespace App\Repositories;

use App\Contracts\Repositories\TransaksiRepositoryInterface;
use App\Models\Transaksi;

class TransaksiRepository extends EloquentRepository implements TransaksiRepositoryInterface
{
    protected function model(): string
    {
        return Transaksi::class;
    }

    protected function withRelations(): array
    {
        return ['pengguna', 'mobil'];
    }

    public function pluckTransaksi(string $value = 'id', string $key = 'id'): \Illuminate\Support\Collection
    {
        return $this->query()->pluck($value, $key);
    }

    public function terbaru(int $limit = 5)
    {
        return $this->query()
            ->with($this->withRelations())
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function byPengguna(int $penggunaId)
    {
        return $this->query()
            ->with($this->withRelations())
            ->where('pengguna_id', $penggunaId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function pendapatanLunasGrouped(string $since, string $dateFormat): array
    {
        return $this->query()
            ->selectRaw("DATE_FORMAT(tanggal_pemesanan, '" . $dateFormat . "') as periode")
            ->selectRaw('SUM(total_harga) as total')
            ->whereIn('status_pembayaran', ['lunas', 'selesai'])
            ->where('tanggal_pemesanan', '>=', $since)
            ->groupBy('periode')
            ->orderBy('periode')
            ->pluck('total', 'periode')
            ->map(fn($total) => (float) $total)
            ->all();
    }

    public function adaTabrakanTanggal(int $mobilId, string $tanggalMulai, string $tanggalSelesai, int $kecualiTransaksiId = null): bool
    {
        $query = $this->query()
            ->where('mobil_id', $mobilId)
            ->whereIn('status_pembayaran', ['pending', 'lunas'])
            ->where('tanggal_mulai', '<=', $tanggalSelesai)
            ->where('tanggal_selesai', '>=', $tanggalMulai);

        if ($kecualiTransaksiId) {
            $query->where('id', '!=', $kecualiTransaksiId);
        }

        return $query->exists();
    }
}
