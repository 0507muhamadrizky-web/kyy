<?php
putenv('VERCEL=1');
$_ENV['VERCEL'] = '1';
$_SERVER['VERCEL'] = '1';

require __DIR__ . '/api/index.php';
echo "SUCCESS!\n";
echo "Packages Path: " . app()->getCachedPackagesPath() . "\n";
