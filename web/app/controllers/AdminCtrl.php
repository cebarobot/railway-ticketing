<?php
namespace app\controllers;

use foundation\Support;
use app\models\HotTrain;
use app\models\User;
use app\models\OrderList;

class AdminCtrl {
    public static function index() {
        $hotTrain = new HotTrain();
        Support::includeView('adminIndex', array(
            'totalOrderCnt' => 1,
            'totalPrice' => 1,
            'hotTrain' => new HotTrain(),
            'userList' => User::getUserList(),
        ));
    }

    public static function initSeatForDay($date) {

    }

    public static function orderList() {
        $orderList = new OrderList();
        if (isset($_GET['userName']) && $_GET['userName']) {
            $user = new User();
            $user->readFromDatabase($_GET['userName']);
            $orderList->queryOfUser($user);
        } else {
            $orderList->queryAll();
        }
        Support::includeView("adminOrderList", array(
            'orderList' => $orderList->list
        ));
        die();
    }
}