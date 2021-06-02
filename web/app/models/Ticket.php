<?php
namespace app\models;

class Ticket extends \foundation\BaseModel {
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
}