<?php
namespace app\models;

use foundation\Database;
use app\models\Auth;


class Ticket extends \foundation\BaseModel {
    public $ticketID;
    public $trainNum;
    public $date;
    public $depSta;
    public $arrSta;
    public $seatType;
    public $price;
    
    public $depTime;
    public $passengerName;
    public $passengerID;

    public function query() {

    }

    public function insert() {
        $trainNum = $this->trainNum;
        $trainDate = $this->date;
        $depSta = $this->depSta;
        $arrSta = $this->arrSta;
        $seatType = $this->seatType;
        $price = $this->price;
        $sql = <<<SQL
insert into TicketInfo (
    trainNum,
    trainDate,
    seatType,
    departureNum,
    arrivalNum,
    price
) values (
    '{$trainNum}',
    '{$trainDate}',
    '{$seatType}',
    (select t_stopnum from train where (t_number = '{$trainNum}' and t_station = '{$depSta}')),
    (select t_stopnum from train where (t_number = '{$trainNum}' and t_station = '{$arrSta}')),
    '{$price}'
) returning id;
SQL;
        $res = Database::query($sql);
        $this->ticketID = intval(Database::fetchRow($res)[0]);
    }

    public function requireSeatInfo() {
        $sql = <<<SQL
SQL;
    }

    public function releaseSeatInfo() {
        
    }
}