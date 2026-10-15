<?php

namespace App\Contracts\Repositories;

interface TransaksiRepositoryInterface extends RepositoryInterface
{
    public function terbaru(int $limit = 5);

    public function byPengguna(int $penggunaId);

    public function pendapatanLunasGrouped(string $since, string $dateFormat): array;

    public function adaTabrakanTanggal(int $mobilId, string $tanggalMulai, string $tanggalSelesai, ?int $kecualiTransaksiId = null): bool;
}
