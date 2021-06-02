<?php
namespace app\controllers;

use foundation\Support;
use app\models\HotTrain;
use app\models\User;
use app\models\OrderList;
use DateTime;
use foundation\Database;

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

    public static function initSeat() {
        $dateStr = (new DateTime($_GET['date']))->format('Y-m-d');
        $sql = <<<SQLEOF
insert into Seat
select TP_TrainNum, '$dateStr', TP_SeatType, TP_ArrivalNum, 5
from TicketPrice;
SQLEOF;
        Database::query($sql);
        header("Location: /admin");
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