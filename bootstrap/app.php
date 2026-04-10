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
if (isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL'])) {
    $tmpPaths = [
        'APP_STORAGE' => '/tmp/storage',
        'APP_SERVICES_CACHE' => '/tmp/cache/services.php',
        'APP_PACKAGES_CACHE' => '/tmp/cache/packages.php',
        'APP_CONFIG_CACHE' => '/tmp/cache/config.php',
        'APP_ROUTES_CACHE' => '/tmp/cache/routes-v7.php',
        'APP_EVENTS_CACHE' => '/tmp/cache/events.php',
        'VIEW_COMPILED_PATH' => '/tmp/storage/framework/views',
        'SESSION_DRIVER' => 'cookie',
        'LOG_CHANNEL' => 'stderr',
    ];
    foreach ($tmpPaths as $key => $val) {
        $_ENV[$key] = $val;
        $_SERVER[$key] = $val;
        putenv("$key=$val");
    }
    $dirs = [
        '/tmp/storage/framework/views',
        '/tmp/storage/framework/cache/data',
        '/tmp/storage/framework/sessions',
        '/tmp/storage/logs',
        '/tmp/cache',
    ];
    foreach ($dirs as $dir) {
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
    }
}

$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

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
