<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$dir = dirname(__DIR__, 1);

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = $dir.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require $dir.'/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once $dir.'/bootstrap/app.php')
    ->handleRequest(Request::capture());
