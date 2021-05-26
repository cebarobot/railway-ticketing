<?php 

define('PAGE_START', microtime(true));
define('PHP_BASE_DIR', __DIR__.'/..');

require PHP_BASE_DIR . "/bootstrap/init.php";

use foundation\Route;

$request = array(
    'method' => $_SERVER['REQUEST_METHOD'],
    'uri' => $_SERVER['REQUEST_URI'],
    'time' => $_SERVER['REQUEST_TIME'],
);

Route::dispatch($request);