<?php

include 'Loader.php';
spl_autoload_register('Loader::autoload');

include __DIR__ . '/../app/routes.php';

use foundation\Database;
Database::init();

use foundation\Session;
Session::init();

use app\models\Auth;
Auth::init();