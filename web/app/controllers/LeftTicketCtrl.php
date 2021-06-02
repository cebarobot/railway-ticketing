<?php

namespace app\controllers;

use DateTime;
use foundation\Support;

class leftTicketCtrl {
    public static function betweenCity() {
        $fromCity = $_GET['fromCity'] ?? '北京';
        $toCity = $_GET['toCity'] ?? '上海';
        $date = $_GET['date'] ?? (new DateTime())->format('Y-m-d');
        Support::includeView("leftTicketsCity", array(
            'type' => 'City',
            'transfer' => false,
            'fromCity' => $fromCity,
            'toCity' => $toCity,
            'curDate' => $date,
            'ticketList' => array(
                array(
                    'trainNum' => 'G1',
                    'depSta' => '北京南',
                    'arrSta' => '上海虹桥',
                    'depTime' => '09:00',
                    'arrTime' => '14:49',
                    'duration' => '4:28',
                    'seatList' => array(
                        array(
                            'seatType' => '商务座',
                            'price' => '1873',
                        ),
                        array(
                            'seatType' => '一等座',
                            'price' => '1000',
                        ),
                        array(
                            'seatType' => '二等座',
                            'price' => '600',
                        )
                    )
                ),
                array(
                    'trainNum' => 'G1',
                    'depSta' => '北京南',
                    'arrSta' => '上海虹桥',
                    'depTime' => '09:00',
                    'arrTime' => '14:49',
                    'duration' => '4:28',
                    'seatList' => array(
                        array(
                            'seatType' => '商务座',
                            'price' => '1873',
                        ),
                        array(
                            'seatType' => '一等座',
                            'price' => '1000',
                        ),
                        array(
                            'seatType' => '二等座',
                            'price' => '600',
                        )
                    )
                ),
            )
        ));
        die();
    }

    public static function betweenCityTransfer() {
        $fromCity = $_GET['fromCity'] ?? '北京';
        $toCity = $_GET['toCity'] ?? '上海';
        $date = $_GET['date'] ?? (new DateTime())->format('Y-m-d');
        Support::includeView("leftTicketsCity", array(
            'type' => 'CityTransfer',
            'transfer' => true,
            'fromCity' => $fromCity,
            'toCity' => $toCity,
            'curDate' => $date,
            'ticketList' => array(
                array(
                    'trainNum' => 'G1',
                    'depSta' => '北京南',
                    'arrSta' => '上海虹桥',
                    'depTime' => '09:00',
                    'arrTime' => '14:49',
                    'duration' => '4:28',
                    'seatList' => array(
                        array(
                            'seatType' => '商务座',
                            'price' => '1873',
                        ),
                        array(
                            'seatType' => '一等座',
                            'price' => '1000',
                        ),
                        array(
                            'seatType' => '二等座',
                            'price' => '600',
                        )
                    )
                ),
                array(
                    'trainNum' => 'G1',
                    'depSta' => '北京南',
                    'arrSta' => '上海虹桥',
                    'depTime' => '09:00',
                    'arrTime' => '14:49',
                    'duration' => '4:28',
                    'seatList' => array(
                        array(
                            'seatType' => '商务座',
                            'price' => '1873',
                        ),
                        array(
                            'seatType' => '一等座',
                            'price' => '1000',
                        ),
                        array(
                            'seatType' => '二等座',
                            'price' => '600',
                        )
                    )
                ),
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
                array(
                    'trainNum' => 'G1',
                    'depSta' => '北京南',
                    'arrSta' => '上海虹桥',
                    'depTime' => '09:00',
                    'arrTime' => '14:49',
                    'duration' => '4:28',
                    'seatList' => array(
                        array(
                            'seatType' => '商务座',
                            'price' => '1873',
                        ),
                        array(
                            'seatType' => '一等座',
                            'price' => '1000',
                        ),
                        array(
                            'seatType' => '二等座',
                            'price' => '600',
                        )
                    )
                ),
                array(
                    'trainNum' => 'G1',
                    'depSta' => '北京南',
                    'arrSta' => '上海虹桥',
                    'depTime' => '09:00',
                    'arrTime' => '14:49',
                    'duration' => '4:28',
                    'seatList' => array(
                        array(
                            'seatType' => '商务座',
                            'price' => '1873',
                        ),
                        array(
                            'seatType' => '一等座',
                            'price' => '1000',
                        ),
                        array(
                            'seatType' => '二等座',
                            'price' => '600',
                        )
                    )
                ),
            )
        ));
        die();
    }
}