<?php

use foundation\Route;

Route::pattern('trainNum', '[KTZDGCSYL]?[0-9]{1,20}');

function asdf() {
    echo "Hello, world, asdf.";
}

Route::any('/', 'Index@index');

Route::any('/logout', 'AuthCtrl@logout');

Route::post('/login', 'AuthCtrl@login');
Route::get('/login', 'AuthCtrl@loginPage');

Route::post('/register', 'AuthCtrl@register');
Route::get('/register', 'AuthCtrl@registerPage');