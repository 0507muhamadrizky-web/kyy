<?php

// =============================================
// Vercel Serverless Entry Point for Laravel
// =============================================

// Mark as Vercel environment so bootstrap/app.php can detect it
$_ENV['VERCEL'] = '1';
$_SERVER['VERCEL'] = '1';
putenv('VERCEL=1');

// Create necessary directories FIRST (before any Laravel code runs)
$dirs = [
    '/tmp/bootstrap/cache',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

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

// Redirect ALL Laravel cache paths to /tmp/bootstrap/cache
setVercelEnv('APP_SERVICES_CACHE', '/tmp/bootstrap/cache/services.php');
setVercelEnv('APP_PACKAGES_CACHE', '/tmp/bootstrap/cache/packages.php');
setVercelEnv('APP_CONFIG_CACHE', '/tmp/bootstrap/cache/config.php');
setVercelEnv('APP_ROUTES_CACHE', '/tmp/bootstrap/cache/routes-v7.php');
setVercelEnv('APP_EVENTS_CACHE', '/tmp/bootstrap/cache/events.php');

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
