<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$storagePath = '/tmp/storage';
foreach ([
    $storagePath.'/app/public',
    $storagePath.'/framework/cache/data',
    $storagePath.'/framework/sessions',
    $storagePath.'/framework/testing',
    $storagePath.'/framework/views',
    $storagePath.'/logs',
] as $directory) {
    if (! is_dir($directory)) {
        @mkdir($directory, 0775, true);
    }
}

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->useStoragePath($storagePath);
$app->handleRequest(Request::capture());
