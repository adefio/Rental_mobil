<?php

use App\Services\SettingsService;
use Illuminate\Support\Facades\Storage;

if (! function_exists('settings')) {
    /**
     * Ambil nilai pengaturan aplikasi.
     *
     * @param  mixed  $default
     */
    function settings(string $key, $default = null)
    {
        return app(SettingsService::class)->get($key, $default);
    }
}

if (! function_exists('gambar_url')) {
    /**
     * URL publik untuk file yang tersimpan di disk penyimpanan aplikasi.
     */
    function gambar_url(?string $path): string
    {
        $disk = config('filesystems.storage_disk');

        if (empty($path)) {
            $path = 'hero/hero-fleet.png';
        }

        if (in_array($disk, ['supabase', 's3'], true)) {
            return Storage::disk($disk)->url($path);
        }

        return asset('storage/'.$path);
    }
}
