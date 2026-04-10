<?php

// =============================================
// Vercel Serverless Entry Point for Laravel
// =============================================

// Storage & cache configuration for Vercel's read-only filesystem
$_ENV['APP_STORAGE'] = '/tmp/storage';
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';
$_ENV['LOG_CHANNEL'] = 'stderr';
$_ENV['SESSION_DRIVER'] = 'cookie';
$_ENV['CACHE_DRIVER'] = 'array';

// Redirect all Laravel cache paths to /tmp
$_ENV['APP_SERVICES_CACHE'] = '/tmp/cache/services.php';
$_ENV['APP_PACKAGES_CACHE'] = '/tmp/cache/packages.php';
$_ENV['APP_CONFIG_CACHE'] = '/tmp/cache/config.php';
$_ENV['APP_ROUTES_CACHE'] = '/tmp/cache/routes-v7.php';
$_ENV['APP_EVENTS_CACHE'] = '/tmp/cache/events.php';

// Create necessary directories in /tmp
$dirs = [
    '/tmp/storage',
    '/tmp/storage/framework',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/cache',
];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Also ensure bootstrap/cache exists (symlink to /tmp)
$bootstrapCache = __DIR__ . '/../bootstrap/cache';
if (!is_dir($bootstrapCache)) {
    @mkdir($bootstrapCache, 0755, true);
}

// =============================================
// Laravel Bootstrap (inlined from public/index.php)
// =============================================

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__ . '/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
