<?php
namespace app\models;

use foundation\Database;
use app\models\Auth;

class Order extends \foundation\BaseModel {
    public $orderID;
    public $orderTime;
    public $status;
    public $ticketList;

    public function query() {
        
    }

    public function insert() {
        $userName = Auth::user()->userName;
        $ticketID1 = isset($this->ticketList[0])? $this->ticketList[0]->ticketID : 'null';
        $ticketID2 = isset($this->ticketList[1])? $this->ticketList[1]->ticketID : 'null';
        $sql = <<<SQLEOF
insert into OrderInfo (
    ticketID1,
    ticketID2,
    orderTime,
    orderStatus,
    userName
) values (
    {$ticketID1},
    {$ticketID2},
    now(),
    'reserved',
    '{$userName}'
) returning id, orderTime;
SQLEOF;
        $res = Database::query($sql);
        $resRow = Database::fetchRow($res);
        $this->orderID = intval($resRow[0]);
        $this->orderTime = $resRow[1];

        var_dump($this);
    }
    public function cancel() {

    }
}