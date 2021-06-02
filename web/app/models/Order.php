<?php
namespace app\models;

use foundation\Database;
use app\models\Auth;
use app\models\Ticket;
use DateTime;

class Order extends \foundation\BaseModel {
    public $orderID;
    public $orderTime;
    public $status;
    public $ticketList;

    public function initFromOrderRow($row) {
        $this->orderID = $row[strtolower('orderID')];
        $this->orderTime = (new DateTime($row[strtolower('orderTime')]))->format('Y-m-d H:i');
        $this->userName = $row[strtolower('userName')];
        $this->status = $row[strtolower('orderStatus')];
        
        $this->ticketList = array();
        $this->ticketList []= new Ticket(array(
            'trainNum' => $row[strtolower('trainNum1')],
            'date' => $row[strtolower('trainDate1')],
            'depSta' => $row[strtolower('depSta1')],
            'depTime' => (new DateTime($row[strtolower('depTime1')]))->format('H:i'),
            'arrSta' => $row[strtolower('arrSta1')],
            'seatType' => $row[strtolower('seatType1')],
            'price' => $row[strtolower('price1')],
        ));
        if ($row[strtolower('trainNum2')]) {
            $this->ticketList []= new Ticket(array(
                'trainNum' => $row[strtolower('trainNum2')],
                'date' => $row[strtolower('trainDate2')],
                'depSta' => $row[strtolower('depSta2')],
                'depTime' => (new DateTime($row[strtolower('depTime2')]))->format('H:i'),
                'arrSta' => $row[strtolower('arrSta2')],
                'seatType' => $row[strtolower('seatType2')],
                'price' => $row[strtolower('price2')],
            ));
        }
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

    public function submit() {
        $this->status = 'reserved';
        foreach ($this->ticketList as $oneTicket) {
            $oneTicket->updateSeatInfo();
            $oneTicket->insert();
        }
        $this->insert();
    }

    public function cancel() {

    }
}