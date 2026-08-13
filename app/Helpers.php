<?php

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
