<?php

namespace app\controllers;

use foundation\Support;
use app\models\Auth;
use app\models\Order;
use app\models\OrderList;
use app\models\Ticket;

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

    public static function orderSumbit() {
        $ticketCnt = $_POST['ticketCnt'];
        $ticketList = array();
        for ($i = 0; $i < $ticketCnt; $i++) {
            $ticketList []= new Ticket(array(
                'trainNum' => $_POST["trainNum-$i"],
                'date' => $_POST["date-$i"],
                'depSta' => $_POST["depSta-$i"],
                'arrSta' => $_POST["arrSta-$i"],
                'seatType' => $_POST["seatType-$i"],
                'price' => $_POST["price-$i"],
            ));
        }
        $order = new Order(array(
            'ticketList' => $ticketList
        ));
        $order->submit();

        header("Location: /orderList");
        die();
    }
    
    public static function orderList() {
        $orderList = new OrderList();
        $orderList->query();
        Support::includeView("orderList", array(
            'orderList' => $orderList->list
        ));
        die();
    }

    public static function orderCancel() {
        $order = new Order();
        $order->initByID(intval($_GET['orderID']));
        $order->cancel();

        header("Location: /orderList");
        die();
    }
}