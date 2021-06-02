<?php

use foundation\Route;

Route::pattern('trainNum', '[KTZDGCSYL]?[0-9]{1,20}');

function asdf() {
    echo "Hello, world, asdf.";
}

Route::any('/', 'StaticPage@index');

Route::any('/logout', 'AuthCtrl@logout');

Route::post('/login', 'AuthCtrl@login');
Route::get('/login', 'AuthCtrl@loginPage');

Route::post('/register', 'AuthCtrl@register');
Route::get('/register', 'AuthCtrl@registerPage');

Route::any('/admin', 'AdminCtrl@index');
Route::any('/admin/initSeat', 'AdminCtrl@initSeat');
Route::any('/admin/orderList', 'AdminCtrl@orderList');

Route::any('/leftTickets/City', 'LeftTicketCtrl@betweenCity');
Route::any('/leftTickets/CityTransfer', 'LeftTicketCtrl@betweenCityTransfer');
Route::any('/leftTickets/Train', 'LeftTicketCtrl@byTrainNum');

Route::post('/orderCheck', 'OrderCtrl@orderCheck');
Route::any('/orderSumbit', 'OrderCtrl@orderSumbit');
Route::any('/orderList', 'OrderCtrl@orderList');
Route::any('/orderCancel', 'OrderCtrl@orderCancel');
Route::any('/orderPrint', 'OrderCtrl@orderPrint');