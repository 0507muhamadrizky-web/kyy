<?php

// =============================================
// Vercel Serverless Entry Point for Laravel
// =============================================

// Helper to set env for all methods Laravel uses to read them
function setVercelEnv($key, $value) {
    $_ENV[$key] = $value;
    $_SERVER[$key] = $value;
    putenv("$key=$value");
}

// Storage & cache for Vercel's read-only filesystem
setVercelEnv('APP_STORAGE', '/tmp/storage');
setVercelEnv('VIEW_COMPILED_PATH', '/tmp/storage/framework/views');
setVercelEnv('LOG_CHANNEL', 'stderr');
setVercelEnv('SESSION_DRIVER', 'cookie');
setVercelEnv('CACHE_DRIVER', 'array');

// Redirect ALL Laravel cache paths to /tmp
setVercelEnv('APP_SERVICES_CACHE', '/tmp/cache/services.php');
setVercelEnv('APP_PACKAGES_CACHE', '/tmp/cache/packages.php');
setVercelEnv('APP_CONFIG_CACHE', '/tmp/cache/config.php');
setVercelEnv('APP_ROUTES_CACHE', '/tmp/cache/routes-v7.php');
setVercelEnv('APP_EVENTS_CACHE', '/tmp/cache/events.php');

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

// =============================================
// Laravel Bootstrap
// =============================================

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
