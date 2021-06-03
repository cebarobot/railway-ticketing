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
        $sql = <<<SQL
select count(*) as cnt from orderinfo;
SQL;
        $res = Database::selectFirst($sql);
        $totalOrderCnt = $res['cnt'];
        $sql = <<<SQL
select count(*) as cnt from orderinfo where orderstatus != 'cancelled';
SQL;
        $res = Database::selectFirst($sql);
        $orderCnt = $res['cnt'];
        $sql = <<<SQL
select
    sum(TicketInfo.price) as sum
from 
    TicketInfo, OrderInfo
where 
    OrderInfo.orderStatus != 'cancelled' and
    (OrderInfo.ticketID1 = TicketInfo.id or OrderInfo.ticketID2 = TicketInfo.id)
;
SQL;
        $res = Database::selectFirst($sql);
        $totalPrice = $res['sum'];
        

        Support::includeView('adminIndex', array(
            'totalOrderCnt' => "$orderCnt($totalOrderCnt)",
            'totalPrice' => "￥$totalPrice",
            'hotTrain' => new HotTrain(),
            'userList' => User::getUserList(),
        ));
    }

    public static function initSeat() {
        $dateStr = (new DateTime($_GET['date']))->format('Y-m-d');
        $sql = <<<SQL
insert into Seat
select TP_TrainNum, '$dateStr', TP_SeatType, TP_ArrivalNum, 5
from TicketPrice;
SQL;
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