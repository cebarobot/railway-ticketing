<?php
namespace app\models;

class LeftTicket extends \foundation\BaseModel {
    public $singleTickets;
    public $seats;
    // public $seatType;
    // public $ticketPrice;

    public function getTrainInfoJson() {
        $trainInfo = array();
        foreach ($this->singleTickets as $oneSingleTicket) {
            $trainInfo []= array(
                'trainNum' => $oneSingleTicket['trainNum'],
                'date' => $oneSingleTicket['date'],
                'depSta' => $oneSingleTicket['depSta'],
                'arrSta' => $oneSingleTicket['arrSta'],
            );
        }
        return htmlspecialchars(json_encode($trainInfo));
    }
}