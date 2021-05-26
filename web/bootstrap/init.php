<?php

include 'Loader.php';
spl_autoload_register('Loader::autoload');

include __DIR__ . '/../app/routes.php';

use foundation\Database;
Database::init();

// var_dump(Database::query("select * from region where 1"));