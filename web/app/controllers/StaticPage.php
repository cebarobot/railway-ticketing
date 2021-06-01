<?php

namespace app\controllers;
use foundation\Support;
use app\models\User;
use app\models\Auth;
use foundation\Session;

class StaticPage {
    public static function index() {
        Support::includeView("index");
        die();
    }

    public static function leftTickets() {
        Support::includeView("leftTickets");
        die();
    }

    public static function orderList() {
        Support::includeView("orderList", array(
            'orderList' => array(
                array(
                    'orderDate' => '2021-06-01',
                    'orderID' => '23333',
                    'ticketList' => array(
                        array(
                            'trainNum' => 'S512',
                            'depSta' => '北京北',
                            'arrSta' => '怀柔北',
                            'date' => '2021-06-01',
                            'depTime' => '16:23',
                            'passengerName' => '徐泽凡',
                            'seatType' => '二等座',
                            'price' => '20',
                            'status' => '已完成'
                        ),
                        array(
                            'trainNum' => 'S512',
                            'depSta' => '北京北',
                            'arrSta' => '怀柔北',
                            'date' => '2021-06-01',
                            'depTime' => '16:23',
                            'passengerName' => '徐泽凡',
                            'seatType' => '二等座',
                            'price' => '20',
                            'status' => '已完成'
                        )
                    )
                )
            )
        ));
        die();
    }
};