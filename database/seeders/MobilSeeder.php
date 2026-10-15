<?php

namespace Database\Seeders;

use App\Models\Mobil;
use Illuminate\Database\Seeder;

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
                'gambar' => ['mobil/3NkIWtz6X8LBGWAAZ54vOjz9hrFWUuBBxA5pCfsJ.webp'],
                'status' => 'tersedia',
            ],
            [
                'nama_mobil' => 'Toyota Innova Reborn',
                'merk' => 'Toyota',
                'tahun' => 2020,
                'harga_sewa' => 650000,
                'deskripsi' => 'MPV premium dengan kabin luas dan nyaman, cocok untuk perjalanan jarak jauh.',
                'gambar' => ['mobil/4tEVAVSCj1UqsULt6JQJ5n6TUOR7pBj17k4drcpS.webp'],
                'status' => 'tersedia',
            ],
            [
                'nama_mobil' => 'Honda Brio',
                'merk' => 'Honda',
                'tahun' => 2022,
                'harga_sewa' => 300000,
                'deskripsi' => 'City car lincah, mudah parkir, dan sangat irit. Pilihan tepat untuk perjalanan kota.',
                'gambar' => ['mobil/5MMLckdTjQOzcAaexw1mbeG3uTEH1gcaDJC28FZw.webp'],
                'status' => 'tersedia',
            ],
            [
                'nama_mobil' => 'Daihatsu Xenia',
                'merk' => 'Daihatsu',
                'tahun' => 2021,
                'harga_sewa' => 330000,
                'deskripsi' => 'MPV 7 seater yang ekonomis, nyaman untuk keluarga kecil.',
                'gambar' => ['mobil/5zqRxbZCmk6sBW8wEAY059GvlSEumrZNHq3ZLsTz.webp'],
                'status' => 'tersedia',
            ],
            [
                'nama_mobil' => 'Mitsubishi Pajero Sport',
                'merk' => 'Mitsubishi',
                'tahun' => 2021,
                'harga_sewa' => 1200000,
                'deskripsi' => 'SUV tangguh untuk segala medan, mesin bertenaga diesel, kabin mewah.',
                'gambar' => ['mobil/AV9fRgyyC4HYbRDhSSzcJs4arYhNLdPntomo3FlT.webp'],
                'status' => 'tersedia',
            ],
            [
                'nama_mobil' => 'Toyota Fortuner',
                'merk' => 'Toyota',
                'tahun' => 2022,
                'harga_sewa' => 1250000,
                'deskripsi' => 'SUV premium dengan performa tinggi, nyaman untuk perjalanan dinas maupun wisata.',
                'gambar' => ['mobil/ciU52nECu3Zp9cX4T8mUk5A1LMdcyhNIcOPb6pJG.webp'],
                'status' => 'tersedia',
            ],
            [
                'nama_mobil' => 'Suzuki Ertiga',
                'merk' => 'Suzuki',
                'tahun' => 2020,
                'harga_sewa' => 320000,
                'deskripsi' => 'MPV compact 7 seater, praktis dan irit untuk pemakaian harian.',
                'gambar' => ['mobil/H1INDv9hqcmxQfK3VQD8QCKVGfoDGcUf9Cy5GpXD.webp'],
                'status' => 'tersedia',
            ],
            [
                'nama_mobil' => 'Hyundai Creta',
                'merk' => 'Hyundai',
                'tahun' => 2023,
                'harga_sewa' => 800000,
                'deskripsi' => 'SUV modern dengan fitur canggih dan desain stylish.',
                'gambar' => ['mobil/mlBwHUhWcR7ziF9oxqKrUAjZeyrNvV8732cQUail.webp'],
                'status' => 'disewa',
            ],
            [
                'nama_mobil' => 'Toyota Alphard',
                'merk' => 'Toyota',
                'tahun' => 2022,
                'harga_sewa' => 2500000,
                'deskripsi' => 'MPV mewah kelas eksekutif dengan kabin super nyaman dan lega.',
                'gambar' => ['mobil/NPEG0yzE1hJ11NYUi9x7hDU3aomL8xG3mfaZ2RNg.webp'],
                'status' => 'maintenance',
            ],
            [
                'nama_mobil' => 'Honda Jazz',
                'merk' => 'Honda',
                'tahun' => 2021,
                'harga_sewa' => 380000,
                'deskripsi' => 'Hatchback fun to drive, desain sporty dengan kabin luas.',
                'gambar' => ['mobil/zGGoDZsjs5YxuVKnrXWvM5AlUMYjZr89wIZjbTf1.webp'],
                'status' => 'tersedia',
            ],
        ];

        foreach ($mobil as $item) {
            Mobil::firstOrCreate([
                'nama_mobil' => $item['nama_mobil'],
                'merk' => $item['merk'],
                'tahun' => $item['tahun'],
            ], $item);
        }
    }
}
