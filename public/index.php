<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Directorio temporal escribible (evita warnings de Symfony al leer php://input en Windows/Laragon)
$appTempDir = __DIR__.'/../storage/framework/temp';
if (! is_dir($appTempDir)) {
    mkdir($appTempDir, 0777, true);
}
ini_set('sys_temp_dir', $appTempDir);
ini_set('upload_tmp_dir', $appTempDir);

// Capturar php://input una sola vez (antes de que Symfony lo consuma o falle en Windows)
$rawInput = file_get_contents('php://input');
$GLOBALS['laravel_raw_input'] = $rawInput !== false ? $rawInput : '';

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
