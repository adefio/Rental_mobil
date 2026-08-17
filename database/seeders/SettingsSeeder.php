<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'nama_aplikasi' => 'Rental Mobil',
            'slogan' => 'Layanan penyewaan mobil terpercaya dengan armada pilihan dan harga bersahabat.',
            'alamat' => 'Jl. Raya Rental No. 123, Jakarta',
            'no_telepon' => '+62 812-3456-7890',
            'email_kontak' => 'halo@rentalmobil.com',
            'tarif_denda_per_hari' => '100000',
            'jam_operasional' => '08.00 - 20.00 WIB',
        ];

        foreach ($defaults as $key => $value) {
            Setting::create([
                'key' => $key,
                'value' => $value,
            ]);
        }
    }
}
