<?php
namespace app\models;

use foundation\Database;

class AllLeftTicketsTrain extends \foundation\BaseModel {
    public $trainNum;
    public $date;
    public $depSta;
    public $arrSta;

    public $list;

    public function query() {
        $trainNum = $this->trainNum;
        $date = $this->date;
        $sql = <<<SQL
with 
sta(StopNum, Station, ArrivalTime, DepartureTime) as (
    select Train.T_StopNum, Train.T_Station, Train.T_ArrivalTime, Train.T_DepartureTime
    from Train
    where Train.T_Number = '$trainNum'
),
p0(StopNum, SeatType, Price) as (
    select TicketPrice.TP_ArrivalNum, TicketPrice.TP_SeatType, TicketPrice.TP_Price
    from TicketPrice
    where TicketPrice.TP_TrainNum = '$trainNum'
),
p_yz(StopNum, Price) as (
    select p0.StopNum, p0.Price
    from p0
    where p0.SeatType = 'YZ'
),
p_rz(StopNum, Price) as (
    select p0.StopNum, p0.Price
    from p0
    where p0.SeatType = 'RZ'
),
p_yw1(StopNum, Price) as (
    select p0.StopNum, p0.Price
    from p0
    where p0.SeatType = 'YW1'
),
p_yw2(StopNum, Price) as (
    select p0.StopNum, p0.Price
    from p0
    where p0.SeatType = 'YW2'
),
p_yw3(StopNum, Price) as (
    select p0.StopNum, p0.Price
    from p0
    where p0.SeatType = 'YW3'
),
p_rw1(StopNum, Price) as (
    select p0.StopNum, p0.Price
    from p0
    where p0.SeatType = 'RW1'
),
p_rw2(StopNum, Price) as (
    select p0.StopNum, p0.Price
    from p0
    where p0.SeatType = 'RW2'
),
p(StopNum, YZPrice, RZPrice,
    YW1Price, YW2Price, YW3Price,
    RW1Price, RW2Price) as (
    select p_yz.StopNum, p_yz.Price, p_rz.Price,
            p_yw1.Price, p_yw2.Price, p_yw3.Price,
            p_rw1.Price, p_rw2.Price
    from p_yz, p_rz, p_yw1, p_yw2, p_yw3, p_rw1, p_rw2
    where p_yz.StopNum = p_rz.StopNum and
          p_yz.StopNum = p_yw1.StopNum and
          p_yz.StopNum = p_yw2.StopNum and
          p_yz.StopNum = p_yw3.StopNum and
          p_yz.StopNum = p_rw1.StopNum and
          p_yz.StopNum = p_rw2.StopNum
),
s0(StopNum, SeatType, TicketLeft) as (
    select Seat.Se_StopNum, Seat.Se_Type, Seat.Se_TicketLeft
    from Seat
    where Seat.Se_TrainNum = '$trainNum' and
          Seat.Se_Date = '$date'
),
s_yz(StopNum, TicketLeft) as (
    select s0.StopNum, s0.TicketLeft
    from s0
    where s0.SeatType = 'YZ'
),
s_rz(StopNum, TicketLeft) as (
    select s0.StopNum, s0.TicketLeft
    from s0
    where s0.SeatType = 'RZ'
),
s_yw1(StopNum, TicketLeft) as (
    select s0.StopNum, s0.TicketLeft
    from s0
    where s0.SeatType = 'YW1'
),
s_yw2(StopNum, TicketLeft) as (
    select s0.StopNum, s0.TicketLeft
    from s0
    where s0.SeatType = 'YW2'
),
s_yw3(StopNum, TicketLeft) as (
    select s0.StopNum, s0.TicketLeft
    from s0
    where s0.SeatType = 'YW3'
),
s_rw1(StopNum, TicketLeft) as (
    select s0.StopNum, s0.TicketLeft
    from s0
    where s0.SeatType = 'RW1'
),
s_rw2(StopNum, TicketLeft) as (
    select s0.StopNum, s0.TicketLeft
    from s0
    where s0.SeatType = 'RW2'
),
s(StopNum, YZTicketLeft, RZTicketLeft,
    YW1TicketLeft, YW2TicketLeft, YW3TicketLeft,
    RW1TicketLeft, RW2TicketLeft) as (
    select s_yz.StopNum, s_yz.TicketLeft, s_rz.TicketLeft,
            s_yw1.TicketLeft, s_yw2.TicketLeft, s_yw3.TicketLeft,
            s_rw1.TicketLeft, s_rw2.TicketLeft
    from s_yz, s_rz, s_yw1, s_yw2, s_yw3, s_rw1, s_rw2
    where s_yz.StopNum = s_rz.StopNum and
          s_yz.StopNum = s_yw1.StopNum and
          s_yz.StopNum = s_yw2.StopNum and
          s_yz.StopNum = s_yw3.StopNum and
          s_yz.StopNum = s_rw1.StopNum and
          s_yz.StopNum = s_rw2.StopNum
)
select sta.Station as Station,
       sta.ArrivalTime as ArrivalTime,
       sta.DepartureTime as DepartureTime,
       p.YZPrice as YZPrice,
       s.YZTicketLeft as YZTicketLeft,
       p.RZPrice as RZPrice,
       s.RZTicketLeft as RZTicketLeft,
       p.YW1Price as YW1Price,
       s.YW1TicketLeft as YW1TicketLeft,
       p.YW2Price as YW2Price,
       s.YW2TicketLeft as YW2TicketLeft,
       p.YW3Price as YW3Price,
       s.YW3TicketLeft as YW3TicketLeft,
       p.RW1Price as RW1Price,
       s.RW1TicketLeft as RW1TicketLeft,
       p.RW2Price as RW2Price,
       s.RW2TicketLeft as RW2TicketLeft
from sta, p, s
where sta.StopNum = p.StopNum and
      sta.StopNum = s.StopNum
order by sta.StopNum;

SQL;
        $res = Database::selectAll($sql);
        // var_dump($res);

        $this->list = array();
        
        $this->depSta = $res[0][strtolower('station')];
        $this->arrSta = $res[count($res) - 1][strtolower('station')];

        foreach ($res as $row) {
            $leftTicket = new LeftTicket();
            $leftTicket->initTrainRow($row, $trainNum, $date, $this->depSta);
            $this->list []= $leftTicket;
        }
    }

}