<?php

namespace app\controllers;

use DateTime;
use foundation\Support;
use app\models\LeftTicket;
use app\models\LeftSingleTicket;
use app\models\AllLeftTicketsCity;
use app\models\AllLeftTicketsCityTransfer;
use app\models\AllLeftTicketsTrain;

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
        $date = $_GET['date'] ?? (new DateTime())->modify('+1 day')->format('Y-m-d');
        $time = $_GET['time'] ?? (new DateTime('00:00'))->format('H:i');
        
        $allLeftTicketsCityTransfer = new AllLeftTicketsCityTransfer(array(
            'fromCity' => $fromCity,
            'toCity' => $toCity,
            'date' => $date,
            'time' => $time,
        ));
        $allLeftTicketsCityTransfer->query();
        
        Support::includeView("leftTicketsCityTransfer", array(
            'type' => 'CityTransfer',
            'transfer' => true,
            'fromCity' => $fromCity,
            'toCity' => $toCity,
            'curDate' => $date,
            'time' => $time,
            'ticketList' => $allLeftTicketsCityTransfer->list
        ));
        die();
    }

    public static function byTrainNum() {
        $trainNum = $_GET['trainNum'] ?? 'G1';
        $date = $_GET['date'] ?? (new DateTime())->format('Y-m-d');
        
        $allTicketsLeftTrain = new AllLeftTicketsTrain(array(
            'trainNum' => $trainNum,
            'date' => $date,
        ));
        $allTicketsLeftTrain->query();

        Support::includeView("leftTicketsTrain", array(
            'type' => 'Train',
            'trainNum' => $trainNum,
            'curDate' => $date,
            'depSta' => $allTicketsLeftTrain->depSta,
            'arrSta' => $allTicketsLeftTrain->arrSta,
            'ticketList' => $allTicketsLeftTrain->list
        ));
        die();
    }
}