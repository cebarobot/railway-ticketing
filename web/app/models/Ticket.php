<?php
namespace app\models;

class Ticket {
    public $trainNum;
    public $date;
    public $depSta;
    public $depTime;
    public $arrSta;
    public $passengerName;
    public $passengerID;
    public $seatType;
    public $price;
    public $status;

    function __construct($param) {
        $this->trainNum = $param['trainNum'] ?? null;
        $this->date = $param['date'] ?? null;
        $this->depSta = $param['depSta'] ?? null;
        $this->depTime = $param['depTime'] ?? null;
        $this->arrSta = $param['arrSta'] ?? null;
        $this->passengerName = $param['passengerName'] ?? null;
        $this->passengerID = $param['passengerID'] ?? null;
        $this->seatType = $param['seatType'] ?? null;
        $this->price = $param['price'] ?? null;
        $this->status = $param['status'] ?? null;
    }
}