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
    public $totalPrice;

    private static function query($cond) {
        $sql = <<<SQL
select
    OrderInfo.id as orderID,
    OrderInfo.orderTime as orderTime,
    OrderInfo.userName as userName,
    OrderInfo.orderStatus as orderStatus,
    Ticket1.trainNum as trainNum1,
    Ticket1.trainDate as trainDate1,
    Ticket1.seatType as seatType1,
    Ticket1.price as price1,
    (select t_station as depSta1 from train where t_number = Ticket1.trainNum and t_stopNum = Ticket1.departureNum),
    (select t_station as arrSta1 from train where t_number = Ticket1.trainNum and t_stopNum = Ticket1.arrivalNum),
    (select t_departuretime as depTime1 from train where t_number = Ticket1.trainNum and t_stopNum = Ticket1.departureNum),
    Ticket2.trainNum as trainNum2,
    Ticket2.trainDate as trainDate2,
    Ticket2.seatType as seatType2,
    Ticket2.price as price2,
    (select t_station as depSta2 from train where t_number = Ticket2.trainNum and t_stopNum = Ticket2.departureNum),
    (select t_station as arrSta2 from train where t_number = Ticket2.trainNum and t_stopNum = Ticket2.arrivalNum),
    (select t_departuretime as depTime2 from train where t_number = Ticket2.trainNum and t_stopNum = Ticket2.departureNum)
from (
    OrderInfo 
    left outer join TicketInfo as Ticket1 on OrderInfo.ticketID1 = Ticket1.id
    left outer join TicketInfo as Ticket2 on OrderInfo.ticketID2 = Ticket2.id
) where {$cond}
order by OrderInfo.id desc;
SQL;
        return Database::selectAll($sql);
    }

    public static function queryOfUser($user) {
        $userName = $user->userName;
        return self::query("OrderInfo.userName = '{$userName}'");
    }

    public static function queryAll() {
        return self::query("true");
    }

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
            'depTime' => $row[strtolower('depTime1')],
            'arrSta' => $row[strtolower('arrSta1')],
            'seatType' => $row[strtolower('seatType1')],
            'price' => $row[strtolower('price1')],
        ));
        if ($row[strtolower('trainNum2')]) {
            $this->ticketList []= new Ticket(array(
                'trainNum' => $row[strtolower('trainNum2')],
                'date' => $row[strtolower('trainDate2')],
                'depSta' => $row[strtolower('depSta2')],
                'depTime' => $row[strtolower('depTime2')],
                'arrSta' => $row[strtolower('arrSta2')],
                'seatType' => $row[strtolower('seatType2')],
                'price' => $row[strtolower('price2')],
            ));
        }
    }

    public function initByID($id) {
        $rows = self::query("OrderInfo.id = {$id}");
        $this->initFromOrderRow($rows[0]);
    }

    public function insert() {
        $userName = Auth::user()->userName;
        $ticketID1 = isset($this->ticketList[0])? $this->ticketList[0]->ticketID : 'null';
        $ticketID2 = isset($this->ticketList[1])? $this->ticketList[1]->ticketID : 'null';
        $sql = <<<SQL
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
SQL;
        $res = Database::query($sql);
        $resRow = Database::fetchRow($res);
        $this->orderID = intval($resRow[0]);
        $this->orderTime = $resRow[1];

        var_dump($this);
    }

    public function submit() {
        $this->status = 'reserved';
        foreach ($this->ticketList as $oneTicket) {
            $oneTicket->requireSeatInfo();
            $oneTicket->insert();
        }
        $this->insert();
    }

    public function cancel() {
        $this->status = 'cancelled';
        foreach ($this->ticketList as $oneTicket) {
            $oneTicket->releaseSeatInfo();
        }
        $orderID = $this->orderID;
        $sql = <<<SQL
update OrderInfo 
set orderStatus = 'cancelled'
where id = {$orderID};
SQL;
        Database::query($sql);
    }
}