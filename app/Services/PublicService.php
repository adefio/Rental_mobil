<?php

namespace App\Services;

use App\Contracts\Repositories\MobilRepositoryInterface;
use App\Contracts\Repositories\PenggunaRepositoryInterface;
use App\Contracts\Repositories\TransaksiRepositoryInterface;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class PublicService
{
    public function __construct(
        protected MobilRepositoryInterface $mobilRepository,
        protected TransaksiRepositoryInterface $transaksiRepository,
        protected PenggunaRepositoryInterface $penggunaRepository
    ) {
    }

    public function homeData(): array
    {
        return [
            'mobil_tersedia' => $this->mobilRepository->tersedia(8),
            'mobil_populer' => $this->mobilRepository->palingPopuler(4),
            'mobil_baru' => $this->mobilRepository->terbaru(4),
            'total_mobil' => $this->mobilRepository->count(),
            'total_pengguna' => $this->penggunaRepository->count(),
            'total_transaksi' => $this->transaksiRepository->count(),
        ];
    }

    public function katalog(string $search = null): Collection
    {
        return $this->mobilRepository->katalog($search);
    }

    public function detail(int $id)
    {
        return $this->mobilRepository->findOrFail($id);
    }

    public function createBooking(int $mobilId, array $data, User $user)
    {
        $mobil = $this->mobilRepository->findOrFail($mobilId);

        if ($mobil->status !== 'tersedia') {
            throw new \DomainException('Mobil sedang tidak tersedia untuk disewa.');
        }

        if ($this->transaksiRepository->adaTabrakanTanggal($mobil->id, $data['tanggal_mulai'], $data['tanggal_selesai'])) {
            throw new \DomainException('Mobil sudah dibooking pada rentang tanggal tersebut. Silakan pilih tanggal atau mobil lain.');
        }

        $pengguna = $this->penggunaRepository->findByUserId($user->id);

        if (!$pengguna) {
            $pengguna = $this->penggunaRepository->create([
                'user_id' => $user->id,
                'nama' => $user->name,
                'email' => $user->email,
                'password' => $user->password,
                'role' => 'pelanggan',
            ]);
        }

        $tanggalMulai = Carbon::parse($data['tanggal_mulai']);
        $tanggalSelesai = Carbon::parse($data['tanggal_selesai']);
        $jumlahHari = $tanggalMulai->diffInDays($tanggalSelesai) + 1;
        $totalHarga = (float) $mobil->harga_sewa * max(1, $jumlahHari);

        $transaksi = $this->transaksiRepository->create([
            'pengguna_id' => $pengguna->id,
            'mobil_id' => $mobil->id,
            'tanggal_pemesanan' => Carbon::today()->toDateString(),
            'tanggal_mulai' => $data['tanggal_mulai'],
            'tanggal_selesai' => $data['tanggal_selesai'],
            'total_harga' => $totalHarga,
            'status_pembayaran' => 'pending',
        ]);

        $this->mobilRepository->update($mobil->id, ['status' => 'disewa']);

        return $transaksi;
    }

    public function pesananSaya(User $user): Collection
    {
        $pengguna = $this->penggunaRepository->findByUserId($user->id);

        if (!$pengguna) {
            return collect();
        }

        return $this->transaksiRepository->byPengguna($pengguna->id);
    }

    public function batalkanPesanan(int $transaksiId, User $user): bool
    {
        $pengguna = $this->penggunaRepository->findByUserId($user->id);

        if (!$pengguna) {
            return false;
        }

        $transaksi = $this->transaksiRepository->findOrFail($transaksiId);

        if ($transaksi->pengguna_id !== $pengguna->id) {
            return false;
        }

        if ($transaksi->status_pembayaran !== 'pending') {
            return false;
        }

        $this->mobilRepository->update($transaksi->mobil_id, ['status' => 'tersedia']);
        $this->transaksiRepository->update($transaksiId, ['status_pembayaran' => 'batal']);

        return true;
    }

    public function konfirmasiPembayaran(int $transaksiId, string $buktiPath, User $user): bool
    {
        $pengguna = $this->penggunaRepository->findByUserId($user->id);

        if (!$pengguna) {
            return false;
        }

        $transaksi = $this->transaksiRepository->findOrFail($transaksiId);

        if ($transaksi->pengguna_id !== $pengguna->id || $transaksi->status_pembayaran !== 'pending') {
            return false;
        }

        $this->transaksiRepository->update($transaksiId, ['bukti_pembayaran' => $buktiPath]);

        return true;
    }
}
