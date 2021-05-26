<?php

use foundation\Route;

Route::pattern('trainNum', '[KTZDGCSYL]?[0-9]{1,20}');

function asdf() {
    echo "Hello, world, asdf.";
}

Route::any('/hello', function() {
    echo "Hello, world";
});
Route::any('/asdf', 'asdf');
Route::any('/', 'Index@index');