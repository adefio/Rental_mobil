<?php

use App\Services\ActivityLogger;
use App\Services\SettingsService;

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

if (! function_exists('log_aktivitas')) {
    /**
     * Catat aktivitas pengguna ke log.
     */
    function log_aktivitas(string $aksi, ?string $deskripsi = null)
    {
        app(ActivityLogger::class)->log($aksi, $deskripsi);
    }
}
