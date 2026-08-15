<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsService
{
    protected array $defaults = [
        'nama_aplikasi' => 'Rental Mobil',
        'slogan' => 'Layanan penyewaan mobil terpercaya dengan armada pilihan dan harga bersahabat.',
        'alamat' => 'Jl. Raya Rental No. 123, Jakarta',
        'no_telepon' => '+62 812-3456-7890',
        'email_kontak' => 'halo@rentalmobil.com',
        'tarif_denda_per_hari' => '100000',
        'jam_operasional' => '08.00 - 20.00 WIB',
        'facebook' => '',
        'instagram' => '',
        'twitter' => '',
        'youtube' => '',
    ];

    public function all(): array
    {
        return Cache::remember('app.settings', 3600, function () {
            $rows = Setting::pluck('value', 'key')->toArray();

            return array_merge($this->defaults, $rows);
        });
    }

    public function get(string $key, $default = null)
    {
        $all = $this->all();

        return array_key_exists($key, $all) ? $all[$key] : $default;
    }

    public function update(array $data): void
    {
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value ?? null]);
        }

        Cache::forget('app.settings');
    }
}
