<?php
namespace app\models;

class LeftSingleTicket extends \foundation\BaseModel {
    public $trainNum;
    public $date;
    public $depSta;
    public $depTime;
    public $arrSta;
    public $arrTime;
    public $travelTime;
    public $seats;

    public function getSeatInfoJson($key) {
        return htmlspecialchars(json_encode($this->seats[$key]));
    }
}