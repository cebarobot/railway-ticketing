<?php
namespace app\models;

use foundation\Database;

class OrderList {
    public $list;

    public function query($all = false) {
        $cond = 'true';
        $sql = <<<SQLEOF
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
) where {$cond};
SQLEOF;
        $allOrders = Database::selectAll($sql);
        $this->list = array();
        foreach ($allOrders as $oneOrder) {
            $thisOrder = new Order();
            $thisOrder->initFromOrderRow($oneOrder);
            $this->list []= $thisOrder;
        }
    }
}