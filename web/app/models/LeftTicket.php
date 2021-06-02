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
}