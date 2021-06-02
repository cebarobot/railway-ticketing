<?php

namespace app\controllers;

use foundation\Support;
use app\models\Auth;

class OrderCtrl {
    public static function orderCheck() {
        $trainInfo = json_decode($_POST['trainInfo'], true);
        $totalPrice = 0;
        foreach ($trainInfo as $key => $oneTrainInfo) {
            $trainInfo[$key]['seatType'] = $_POST['seatType-'.$key];
            $trainInfo[$key]['price'] = $_POST['price-'.$key];
            $totalPrice += intval($trainInfo[$key]['price']);
        }
        Support::includeView('orderCheck', array(
            'trainInfo' => $trainInfo,
            'passengerName' => Auth::user()->name,
            'passengerID' => Auth::user()->id,
            'totalPrice' => $totalPrice,
        ));
        die();
    }
}