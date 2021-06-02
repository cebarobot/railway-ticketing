<?php

namespace app\controllers;

use DateTime;
use foundation\Support;
use app\models\LeftTicket;
use app\models\LeftSingleTicket;
use app\models\AllLeftTicketsCity;

class leftTicketCtrl {
    public static function betweenCity() {
        $fromCity = $_GET['fromCity'] ?? '北京';
        $toCity = $_GET['toCity'] ?? '上海';
        $date = $_GET['date'] ?? (new DateTime())->modify('+1 day')->format('Y-m-d');
        $time = $_GET['time'] ?? (new DateTime('00:00'))->format('H:i');

        $allTicketsLeftCity = new AllLeftTicketsCity(array(
            'fromCity' => $fromCity,
            'toCity' => $toCity,
            'date' => $date,
            'time' => $time,
        ));
        $allTicketsLeftCity->query();
        Support::includeView("leftTicketsCity", array(
            'type' => 'City',
            'transfer' => false,
            'fromCity' => $fromCity,
            'toCity' => $toCity,
            'curDate' => $date,
            'time' => $time,
            'ticketList' => $allTicketsLeftCity->list
        ));
        die();
    }

    public static function betweenCityTransfer() {
        $fromCity = $_GET['fromCity'] ?? '北京';
        $toCity = $_GET['toCity'] ?? '上海';
        $date = $_GET['date'] ?? (new DateTime())->format('Y-m-d');
        Support::includeView("leftTicketsCityTransfer", array(
            'type' => 'CityTransfer',
            'transfer' => true,
            'fromCity' => $fromCity,
            'toCity' => $toCity,
            'curDate' => $date,
            'ticketList' => array(
                new LeftTicket(array(
                    'singleTickets' => array(
                        new LeftSingleTicket(array(
                            'trainNum' => 'G1',
                            'date' => '2021-06-04',
                            'depSta' => '北京南',
                            'arrSta' => '上海虹桥',
                            'depTime' => '09:00',
                            'arrTime' => '14:49',
                            'travelTime' => '4:28',
                            'seats' => array(
                                array(
                                    'seatType' => 'RZ',
                                    'price' => '1000',
                                ),
                                array(
                                    'seatType' => 'YZ',
                                    'price' => '600',
                                )
                            )
                        )),
                        new LeftSingleTicket(array(
                            'trainNum' => 'G1',
                            'date' => '2021-06-04',
                            'depSta' => '北京南',
                            'arrSta' => '上海虹桥',
                            'depTime' => '09:00',
                            'arrTime' => '14:49',
                            'travelTime' => '4:28',
                            'seats' => array(
                                array(
                                    'seatType' => 'RZ',
                                    'price' => '1000',
                                ),
                                array(
                                    'seatType' => 'YZ',
                                    'price' => '600',
                                )
                            )
                        )),
                    ),
                )),
            )
        ));
        die();
    }

    public static function byTrainNum() {
        $trainNum = $_GET['trainNum'] ?? 'G1';
        $depSta = $_GET['depSta'] ?? '北京南';
        $date = $_GET['date'] ?? (new DateTime())->format('Y-m-d');
        Support::includeView("leftTicketsTrain", array(
            'type' => 'Train',
            'trainNum' => $trainNum,
            'depSta' => $depSta,
            'curDate' => $date,
            'ticketList' => array(
                new LeftTicket(array(
                    'singleTickets' => array(
                        new LeftSingleTicket(array(
                            'trainNum' => 'G1',
                            'date' => '2021-06-04',
                            'depSta' => '北京南',
                            'arrSta' => '上海虹桥',
                            'depTime' => '09:00',
                            'arrTime' => '14:49',
                            'travelTime' => '4:28',
                            'seats' => array(
                                array(
                                    'seatType' => 'RZ',
                                    'price' => '1000',
                                ),
                                array(
                                    'seatType' => 'YZ',
                                    'price' => '600',
                                )
                            )
                        )),
                    ),
                )),
            )
        ));
        die();
    }
}