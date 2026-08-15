<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Layani aset statis (hasil build Vite, favicon) langsung dari folder public/.
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$publicDir = realpath(__DIR__.'/../public');

if ($publicDir !== false && is_string($uri) && $uri !== '/') {
    $real = realpath($publicDir.DIRECTORY_SEPARATOR.ltrim($uri, '/'));

    if ($real !== false && is_file($real) && str_starts_with($real, $publicDir.DIRECTORY_SEPARATOR)) {
        $mime = match (strtolower(pathinfo($real, PATHINFO_EXTENSION))) {
            'css' => 'text/css',
            'js', 'mjs' => 'application/javascript',
            'json' => 'application/json',
            'png' => 'image/png',
            'jpg', 'jpeg' => 'image/jpeg',
            'webp' => 'image/webp',
            'svg' => 'image/svg+xml',
            'woff', 'woff2' => 'font/woff2',
            'ico' => 'image/x-icon',
            default => mime_content_type($real) ?: 'application/octet-stream',
        };

        header('Content-Type: '.$mime);
        header('Cache-Control: public, max-age=31536000, immutable');
        readfile($real);
        exit;
    }
}

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$app->useStoragePath('/tmp/storage');

foreach (['logs', 'framework/cache/data', 'framework/sessions', 'framework/views'] as $dir) {
    $path = '/tmp/storage/'.$dir;

    if (! is_dir($path)) {
        @mkdir($path, 0777, true);
    }
}

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
