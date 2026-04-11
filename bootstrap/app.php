<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

/*
|--------------------------------------------------------------------------
| Vercel Serverless: Force /tmp for read-only filesystem
|--------------------------------------------------------------------------
*/
if (!is_writable(__DIR__ . '/cache') || isset($_ENV['VERCEL'])) {
    // Create ALL /tmp directories FIRST, before anything else
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

    $tmpPaths = [
        'APP_STORAGE' => '/tmp/storage',
        'APP_SERVICES_CACHE' => '/tmp/bootstrap/cache/services.php',
        'APP_PACKAGES_CACHE' => '/tmp/bootstrap/cache/packages.php',
        'APP_CONFIG_CACHE' => '/tmp/bootstrap/cache/config.php',
        'APP_ROUTES_CACHE' => '/tmp/bootstrap/cache/routes-v7.php',
        'APP_EVENTS_CACHE' => '/tmp/bootstrap/cache/events.php',
        'VIEW_COMPILED_PATH' => '/tmp/storage/framework/views',
        'SESSION_DRIVER' => 'cookie',
        'LOG_CHANNEL' => 'stderr',
        'CACHE_DRIVER' => 'array',
    ];
    foreach ($tmpPaths as $key => $val) {
        $_ENV[$key] = $val;
        $_SERVER[$key] = $val;
        putenv("$key=$val");
    }
}

$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

// Override paths for Vercel's read-only filesystem
if (!is_writable(__DIR__ . '/cache') || isset($_ENV['VERCEL'])) {
    $app->useStoragePath('/tmp/storage');
    $app->useBootstrapPath('/tmp/bootstrap');

    // CRITICAL: Re-register PackageManifest with the correct /tmp path.
    // PackageManifest is created inside Application::__construct() via
    // registerBaseBindings(), BEFORE Env::get() can read our env overrides
    // (DotEnv repository isn't initialized yet). So it falls back to the
    // default read-only bootstrap/cache path. We must replace it here.
    $app->instance(
        \Illuminate\Foundation\PackageManifest::class,
        new \Illuminate\Foundation\PackageManifest(
            new \Illuminate\Filesystem\Filesystem,
            $app->basePath(),
            '/tmp/bootstrap/cache/packages.php'
        )
    );
}

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/


$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
