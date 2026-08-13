<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MobilSeeder extends Seeder
{
    public function run(): void
    {
        $mobil = [
            [
                'nama_mobil' => 'Toyota Avanza',
                'merk' => 'Toyota',
                'tahun' => 2021,
                'harga_sewa' => 350000,
                'deskripsi' => 'MPV keluarga 7 seater, irit bahan bakar, cocok untuk perjalanan keluarga atau wisata.',
                'status' => 'tersedia',
            ],
            [
                'nama_mobil' => 'Toyota Innova Reborn',
                'merk' => 'Toyota',
                'tahun' => 2020,
                'harga_sewa' => 650000,
                'deskripsi' => 'MPV premium dengan kabin luas dan nyaman, cocok untuk perjalanan jarak jauh.',
                'status' => 'tersedia',
            ],
            [
                'nama_mobil' => 'Honda Brio',
                'merk' => 'Honda',
                'tahun' => 2022,
                'harga_sewa' => 300000,
                'deskripsi' => 'City car lincah, mudah parkir, dan sangat irit. Pilihan tepat untuk perjalanan kota.',
                'status' => 'tersedia',
            ],
            [
                'nama_mobil' => 'Daihatsu Xenia',
                'merk' => 'Daihatsu',
                'tahun' => 2021,
                'harga_sewa' => 330000,
                'deskripsi' => 'MPV 7 seater yang ekonomis, nyaman untuk keluarga kecil.',
                'status' => 'tersedia',
            ],
            [
                'nama_mobil' => 'Mitsubishi Pajero Sport',
                'merk' => 'Mitsubishi',
                'tahun' => 2021,
                'harga_sewa' => 1200000,
                'deskripsi' => 'SUV tangguh untuk segala medan, mesin bertenaga diesel, kabin mewah.',
                'status' => 'tersedia',
            ],
            [
                'nama_mobil' => 'Toyota Fortuner',
                'merk' => 'Toyota',
                'tahun' => 2022,
                'harga_sewa' => 1250000,
                'deskripsi' => 'SUV premium dengan performa tinggi, nyaman untuk perjalanan dinas maupun wisata.',
                'status' => 'tersedia',
            ],
            [
                'nama_mobil' => 'Suzuki Ertiga',
                'merk' => 'Suzuki',
                'tahun' => 2020,
                'harga_sewa' => 320000,
                'deskripsi' => 'MPV compact 7 seater, praktis dan irit untuk pemakaian harian.',
                'status' => 'tersedia',
            ],
            [
                'nama_mobil' => 'Hyundai Creta',
                'merk' => 'Hyundai',
                'tahun' => 2023,
                'harga_sewa' => 800000,
                'deskripsi' => 'SUV modern dengan fitur canggih dan desain stylish.',
                'status' => 'disewa',
            ],
            [
                'nama_mobil' => 'Toyota Alphard',
                'merk' => 'Toyota',
                'tahun' => 2022,
                'harga_sewa' => 2500000,
                'deskripsi' => 'MPV mewah kelas eksekutif dengan kabin super nyaman dan lega.',
                'status' => 'maintenance',
            ],
            [
                'nama_mobil' => 'Honda Jazz',
                'merk' => 'Honda',
                'tahun' => 2021,
                'harga_sewa' => 380000,
                'deskripsi' => 'Hatchback fun to drive, desain sporty dengan kabin luas.',
                'status' => 'tersedia',
            ],
        ];

        DB::table('mobil')->insert($mobil);
    }
}
