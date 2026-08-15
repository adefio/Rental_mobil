<?php

namespace Database\Seeders;

use App\Models\Pesan;
use App\Models\Pengembalian;
use App\Models\Pengguna;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedAkunDemo();

        if (Transaksi::count() === 0) {
            $this->seedTransaksiDemo();
        }

        if (Pesan::count() === 0) {
            $this->seedPesanDemo();
        }
    }

    protected function seedAkunDemo(): void
    {
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@rentalmobil.test'],
            [
                'name' => 'Admin Rental',
                'password' => Hash::make('password123'),
            ]
        );

        Pengguna::firstOrCreate(
            ['user_id' => $adminUser->id],
            [
                'nama' => 'Admin Rental',
                'email' => 'admin@rentalmobil.test',
                'password' => $adminUser->password,
                'role' => 'admin',
                'no_telepon' => '+62 812-3456-7890',
                'alamat' => 'Jl. Raya Rental No. 123, Jakarta',
            ]
        );

        $pelangganUser = User::firstOrCreate(
            ['email' => 'test@gmail.test'],
            [
                'name' => 'Test Pelanggan',
                'password' => Hash::make('password123'),
            ]
        );

        Pengguna::firstOrCreate(
            ['user_id' => $pelangganUser->id],
            [
                'nama' => 'Test Pelanggan',
                'email' => 'test@gmail.test',
                'password' => $pelangganUser->password,
                'role' => 'pelanggan',
                'no_telepon' => '0812-3456-7891',
                'alamat' => 'Jl. Melati No. 45, Jakarta Selatan',
            ]
        );
    }

    protected function seedTransaksiDemo(): void
    {
        $pelangganId = Pengguna::where('role', 'pelanggan')->value('id');

        $data = [
            // Selesai (kembali), tersebar agar grafik pendapatan terisi
            ['mobil' => 1, 'bulan' => -6, 'mulai' => -6, 'total' => 1050000],
            ['mobil' => 3, 'bulan' => -4, 'mulai' => -4, 'total' => 900000],
            ['mobil' => 5, 'bulan' => -2, 'mulai' => -2, 'total' => 2400000],
            ['mobil' => 7, 'bulan' => -3, 'mulai' => -3, 'total' => 0], // bulan sebelumnya (hampir 3 bulan)
            ['mobil' => 9, 'bulan' => -5, 'mulai' => -5, 'total' => 0], // 5 bulan lalu
            ['mobil' => 10, 'bulan' => -3, 'mulai' => -3, 'total' => 0], // tahun lalu
            ['mobil' => 2, 'bulan' => -14, 'mulai' => -14, 'total' => 0], // 14 bulan lalu (tahunan)
            ['mobil' => 8, 'bulan' => -30, 'mulai' => -30, 'total' => 0], // 30 bulan lalu (tahunan)
            // Lunas aktif (sedang berjalan)
            ['mobil' => 4, 'mulai' => 0, 'selesai' => 3, 'total' => 0, 'status' => 'lunas'],
            // Pending (menunggu pembayaran)
            ['mobil' => 6, 'mulai' => 1, 'selesai' => 3, 'total' => 0, 'status' => 'pending'],
            // Batal
            ['mobil' => 1, 'mulai' => -10, 'selesai' => -8, 'total' => 0, 'status' => 'batal'],
        ];

        $i = 0;

        foreach ($data as $item) {
            $i++;

            $mulai = $item['mulai'] !== null
                ? now()->addDays($item['mulai'])
                : $tanggalPemesanan->copy()->addDay();

            $selesai = isset($item['selesai'])
                ? now()->addDays($item['selesai'])
                : $mulai->copy()->addDays(2);

            if (($item['bulan'] ?? null) !== null) {
                $tanggalPemesanan = now()->addMonths($item['bulan'])->startOfMonth()->addDays(min($i, 20));
            } else {
                $tanggalPemesanan = $mulai->copy()->subDays(min($i, 7));
            }

            $mobil = \App\Models\Mobil::find($item['mobil']);

            if (!$mobil) {
                continue;
            }

            $total = $item['total'] > 0
                ? $item['total']
                : (float) $mobil->harga_sewa * (max(1, $mulai->diffInDays($selesai)) + 1);

            $status = $item['status'] ?? 'selesai';

            $transaksi = Transaksi::create([
                'pengguna_id' => $pelangganId,
                'mobil_id' => $mobil->id,
                'tanggal_pemesanan' => $tanggalPemesanan->toDateString(),
                'tanggal_mulai' => $mulai->toDateString(),
                'tanggal_selesai' => $selesai->toDateString(),
                'total_harga' => $total,
                'status_pembayaran' => $status,
            ]);

            if ($status === 'selesai') {
                Pengembalian::create([
                    'transaksi_id' => $transaksi->id,
                    'denda_telat' => 0,
                    'biaya_kerusakan' => 0,
                    'tanggal_pengembalian' => $selesai->copy()->addDays($i % 2)->toDateString(),
                ]);
            }
        }

        $this->sinkronkanStatusMobil();
    }

    protected function sinkronkanStatusMobil(): void
    {
        $mobilTersedia = Transaksi::whereIn('status_pembayaran', ['batal', 'selesai'])
            ->pluck('mobil_id')
            ->unique();

        $mobilDisewa = Transaksi::whereIn('status_pembayaran', ['pending', 'lunas'])
            ->pluck('mobil_id')
            ->unique();

        \App\Models\Mobil::whereIn('id', $mobilTersedia)->update(['status' => 'tersedia']);
        \App\Models\Mobil::whereIn('id', $mobilDisewa)->update(['status' => 'disewa']);
    }

    protected function seedPesanDemo(): void
    {
        Pesan::create([
            'nama' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'no_telepon' => '0812-9999-0000',
            'subjek' => 'Tanya ketersediaan mobil',
            'pesan' => 'Halo, apakah Toyota Avanza masih tersedia untuk sewa akhir pekan depan?',
            'dibaca' => false,
        ]);

        Pesan::create([
            'nama' => 'Siti Aminah',
            'email' => 'siti@example.com',
            'no_telepon' => '0813-1111-2222',
            'subjek' => 'Harga sewa bulanan',
            'pesan' => 'Apakah ada diskon untuk sewa jangka panjang (1 bulan)? Terima kasih.',
            'dibaca' => true,
        ]);
    }
}
