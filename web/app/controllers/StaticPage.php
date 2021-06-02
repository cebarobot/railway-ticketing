<?php

namespace app\controllers;

use foundation\Support;
use foundation\Session;

use app\models\User;
use app\models\Auth;
use app\models\Order;
use app\models\Ticket;

class StaticPage {
    public static function index() {
        Support::includeView("index");
        die();
    }

    public static function orderList() {
        Support::includeView("orderList", array(
            'orderList' => array(
                new Order(array(
                    'orderDate' => '2021-06-01',
                    'orderID' => '23333',
                    'ticketList' => array(
                        new Ticket(array(
                            'trainNum' => 'S512',
                            'depSta' => '北京北',
                            'arrSta' => '怀柔北',
                            'date' => '2021-06-01',
                            'depTime' => '16:23',
                            'passengerName' => '徐泽凡',
                            'seatType' => '二等座',
                            'price' => '20',
                            'status' => '已完成'
                        )),
                        new Ticket(array(
                            'trainNum' => 'S612',
                            'depSta' => '北京西',
                            'arrSta' => '通州西',
                            'date' => '2021-06-01',
                            'depTime' => '16:23',
                            'passengerName' => '徐泽凡',
                            'seatType' => '二等座',
                            'price' => '20',
                            'status' => '已完成'
                        ))
                    )
                ))
            )
        ));
        die();
    }

    public static function orderCheck() {
        Support::includeView('orderCheck');
        die();
    }
};