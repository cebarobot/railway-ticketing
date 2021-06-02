<?php

namespace app\controllers;

use foundation\Support;
use app\models\Auth;

class OrderCtrl {
    public static function orderCheck() {
        $trainInfo = json_decode($_POST['trainInfo'], true);
        $totalPrice = 0;
        foreach ($trainInfo as $key => $oneTrainInfo) {
            $seatInfo = json_decode($_POST['seatInfo-'.$key], true);
            $trainInfo[$key]['seatType'] = $seatInfo['seatType'];
            $trainInfo[$key]['price'] = $seatInfo['price'];
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