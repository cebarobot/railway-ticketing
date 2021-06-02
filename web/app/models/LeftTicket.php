<?php
namespace app\models;

use DateInterval;

class LeftTicket extends \foundation\BaseModel {
    public $singleTickets;

    public function getTrainInfoJson() {
        $trainInfo = array();
        foreach ($this->singleTickets as $oneSingleTicket) {
            $trainInfo []= array(
                'trainNum' => $oneSingleTicket->trainNum,
                'date' => $oneSingleTicket->date,
                'depSta' => $oneSingleTicket->depSta,
                'arrSta' => $oneSingleTicket->arrSta,
            );
        }
        return htmlspecialchars(json_encode($trainInfo));
    }

    public function initCityRow($row, $date) {
        $oneSingleTicket = new LeftSingleTicket(array(
            'trainNum' => $row[strtolower('TrainNum')],
            'date' => $date,
            'depSta' => $row[strtolower('DepartureSta')],
            'depTime' => $row[strtolower('DepartureTime')],
            'arrSta' => $row[strtolower('ArrivalSta')],
            'arrTime' => $row[strtolower('ArrivalTime')],
            'travelTime' => $row[strtolower('TotalTime')]
        ));
        $seats = array();
        foreach (Symbol::$seatTypeMap as $seatType => $value) {
            $price = $row[strtolower($seatType.'Price')];
            $ticketLeft = $row[strtolower($seatType.'TicketLeft')];
            if ($price && $ticketLeft) {
                $seats []= array(
                    'seatType' => $seatType,
                    'price' => floatval($price),
                    'ticketLeft' => intval($ticketLeft),
                );
            }
        }
        $oneSingleTicket->seats = $seats;
        $this->singleTickets = array(
            $oneSingleTicket
        );
    }

    public function initCityTransferRow($row, $date) {
        $oneSingleTicket = new LeftSingleTicket(array(
            'trainNum' => $row[strtolower('TrainNum1')],
            'date' => $date,
            'depSta' => $row[strtolower('Station1')],
            'depTime' => $row[strtolower('DepartureTime')],
            'arrSta' => $row[strtolower('Station2')],
            'arrTime' => $row[strtolower('TransferTime1')]
        ));
        $oneSeats = array();
        foreach (Symbol::$seatTypeMap as $seatType => $value) {
            $price = $row[strtolower($seatType.'Price1')];
            $ticketLeft = $row[strtolower($seatType.'TicketLeft1')];
            if ($price && $ticketLeft) {
                $oneSeats []= array(
                    'seatType' => $seatType,
                    'price' => floatval($price),
                    'ticketLeft' => intval($ticketLeft),
                );
            }
        }
        $oneSingleTicket->seats = $oneSeats;

        $twoSingleTicket = new LeftSingleTicket(array(
            'trainNum' => $row[strtolower('TrainNum2')],
            'date' => $date,
            'depSta' => $row[strtolower('Station3')],
            'depTime' => $row[strtolower('TransferTime2')],
            'arrSta' => $row[strtolower('Station4')],
            'arrTime' => $row[strtolower('ArrivalTime')],
            'travelTime' => $row[strtolower('TotalTime')]
        ));
        $twoSeats = array();
        foreach (Symbol::$seatTypeMap as $seatType => $value) {
            $price = $row[strtolower($seatType.'Price2')];
            $ticketLeft = $row[strtolower($seatType.'TicketLeft2')];
            if ($price && $ticketLeft) {
                $twoSeats []= array(
                    'seatType' => $seatType,
                    'price' => floatval($price),
                    'ticketLeft' => intval($ticketLeft),
                );
            }
        }
        $twoSingleTicket->seats = $twoSeats;

        $this->singleTickets = array(
            $oneSingleTicket,
            $twoSingleTicket,
        );
    }

    public function initTrainRow($row, $trainNum, $date, $depSta) {
        $oneSingleTicket = new LeftSingleTicket(array(
            'trainNum' => $trainNum,
            'date' => $date,
            'depSta' => $depSta,
            'arrSta' => $row[strtolower('station')],
            'arrTime' => $row[strtolower('ArrivalTime')],
            'depTime' => $row[strtolower('DepartureTime')],
        ));
        $seats = array();
        foreach (Symbol::$seatTypeMap as $seatType => $value) {
            $price = $row[strtolower($seatType.'Price')];
            $ticketLeft = $row[strtolower($seatType.'TicketLeft')];
            if ($price && $ticketLeft) {
                $seats []= array(
                    'seatType' => $seatType,
                    'price' => floatval($price),
                    'ticketLeft' => intval($ticketLeft),
                );
            }
        }
        $oneSingleTicket->seats = $seats;
        $this->singleTickets = array(
            $oneSingleTicket
        );
    }
}