<?php
namespace app\models;

use foundation\Database;

class AllLeftTicketsCityTransfer extends \foundation\BaseModel {
    public $fromCity;
    public $toCity;
    public $date;
    public $time;

    public $list;

    public function query() {
        $fromCity = $this->fromCity;
        $toCity = $this->toCity;
        $date = $this->date;
        $time = $this->time;
        $sql = <<<SQL
with
T1(T1_TrainNum, T1_StopNum) as (                            -- 经过出发地的列车
      select Train.T_Number, Train.T_StopNum
      from Train, Station
      where Train.T_Station = Station.St_Name and
            Station.St_City = '$fromCity' and
            Train.T_DepartureTime >= '$time'
),
T2(T2_TrainNum, T2_StopNum) as (                            -- 经过到达地的列车
      select Train.T_Number, Train.T_StopNum
      from Train, Station
      where Train.T_Station = Station.St_Name and
            Station.St_City = '$toCity'
),
S1(S1_TrainNum, S1_Station, S1_City, S1_Time) as (                      -- T1 的列车接下来经过的车站
      select Train.T_Number, Train.T_Station, 
            Station.St_City, Train.T_ArrivalTime
      from Train, T1, Station
      where Train.T_Number = T1.T1_TrainNum and
            Train.T_StopNum > T1.T1_StopNum and
            Train.T_Station = Station.St_Name 
),
S2(S2_TrainNum, S2_Station, S2_City, S2_Time) as (                      -- T2 的列车之前经过的车站
      select Train.T_Number, Train.T_Station, 
            Station.St_City, Train.T_DepartureTime
      from Train, T2, Station
      where Train.T_Number = T2.T2_TrainNum and
            Train.T_StopNum < T2.T2_StopNum and
            Train.T_Station = Station.St_Name
),
S3(S3_TrainNum1, S3_TrainNum2, S3_Station1, S3_Station2, S3_City, S3_Time) as (           -- 中间有相同城市的列车
      select S1.S1_TrainNum, S2.S2_TrainNum, 
            S1.S1_Station, S2.S2_Station, S1.S1_City,
            (case when (S2.S2_Time - S1.S1_Time) < '-72:00:00' then S2.S2_Time - S1.S1_Time + '96:00:00'
                  when (S2.S2_Time - S1.S1_Time) < '-48:00:00' then S2.S2_Time - S1.S1_Time + '72:00:00'
                  when (S2.S2_Time - S1.S1_Time) < '-24:00:00' then S2.S2_Time - S1.S1_Time + '48:00:00'
                  when (S2.S2_Time - S1.S1_Time) < '0:0:0' then S2.S2_Time - S1.S1_Time + '24:00:00'
                  when (S2.S2_Time - S1.S1_Time) > '72:00:00' then S2.S2_Time - S1.S1_Time - '72:00:00'
                  when (S2.S2_Time - S1.S1_Time) > '48:00:00' then S2.S2_Time - S1.S1_Time - '48:00:00'
                  when (S2.S2_Time - S1.S1_Time) > '24:00:00' then S2.S2_Time - S1.S1_Time - '24:00:00'
                  else S2.S2_Time - S1.S1_Time
            end) 
      from S1, S2
      where S1.S1_City = S2.S2_City and
            S1.S1_TrainNum != S2.S2_TrainNum
),
S5(TrainNum1, TrainNum2, Station1, Station2, City, t) as (
      select S3.S3_TrainNum1, S3.S3_TrainNum2, 
            S3.S3_Station1, S3.S3_Station2, S3.S3_City, S3.S3_Time
      from S3
      where S3.S3_Time <= '4:00:00' and
            S3.S3_Station1 = S3.S3_Station2 and
            S3.S3_Time >= '1:00:00'
      order by S3.S3_Time
      limit 200
),
S6(TrainNum1, TrainNum2, Station1, Station2, City, t) as (
      select S3.S3_TrainNum1, S3.S3_TrainNum2, 
            S3.S3_Station1, S3.S3_Station2, S3.S3_City, S3.S3_Time
      from S3
      where S3.S3_Time <= '4:00:00' and
            S3.S3_Station1 != S3.S3_Station2 and
            S3.S3_Time >= '2:00:00'
      order by S3.S3_Time
      limit 200
),
S4(S4_TrainNum1, S4_TrainNum2, S4_Station1, S4_Station2, S4_City, S4_Time) as (              -- 满足换乘时间要求
      select * from S5
      union
      select * from S6
),
Price1(TrainNum1, TrainNum2, City, SeatType, Price) as (                            -- T1 始发站到出发站的票价
      select distinct
            S4.S4_TrainNum1, S4.S4_TrainNum2, S4.S4_City,
            TicketPrice.TP_SeatType, TicketPrice.TP_Price
      from TicketPrice, S4, Train, Station
      where Train.T_Number = S4.S4_TrainNum1 and
            Train.T_Station = Station.St_Name and
            Station.St_City = '$fromCity' and
            Train.T_Number = TicketPrice.TP_TrainNum and
            Train.T_StopNum = TicketPrice.TP_ArrivalNum
),
Price2(TrainNum1, TrainNum2, City, SeatType, Price) as (                   -- T1 始发站到换乘站的票价
      select distinct 
            S4.S4_TrainNum1, S4.S4_TrainNum2, S4.S4_City,
            TicketPrice.TP_SeatType, TicketPrice.TP_Price
      from TicketPrice, S4, Train
      where Train.T_Number = S4.S4_TrainNum1 and
            Train.T_Station = S4.S4_Station1 and
            Train.T_Number = TicketPrice.TP_TrainNum and
            Train.T_StopNum = TicketPrice.TP_ArrivalNum and
            TicketPrice.TP_Price != 0
),
Price5(TrainNum1, TrainNum2, City, SeatType, Price) as (
      select Price1.TrainNum1, Price1.TrainNum2, Price1.City,
            Price1.SeatType, Price2.Price - Price1.Price
      from Price1, Price2
      where Price1.TrainNum1 = Price2.TrainNum1 and
            Price1.TrainNum2 = Price2.TrainNum2 and
            Price1.City = Price2.City and
            Price1.SeatType = Price2.SeatType
),
p1_yz(TrainNum1, TrainNum2, City, Price) as (
      select Price5.TrainNum1, Price5.TrainNum2, Price5.City, Price5.Price
      from Price5
      where Price5.SeatType = 'YZ'
),
p1_rz(TrainNum1, TrainNum2, City, Price) as (
      select Price5.TrainNum1, Price5.TrainNum2, Price5.City, Price5.Price
      from Price5
      where Price5.SeatType = 'RZ'
),
p1_yw1(TrainNum1, TrainNum2, City, Price) as (
      select Price5.TrainNum1, Price5.TrainNum2, Price5.City, Price5.Price
      from Price5
      where Price5.SeatType = 'YW1'
),
p1_yw2(TrainNum1, TrainNum2, City, Price) as (
      select Price5.TrainNum1, Price5.TrainNum2, Price5.City, Price5.Price
      from Price5
      where Price5.SeatType = 'YW2'
),
p1_yw3(TrainNum1, TrainNum2, City, Price) as (
      select Price5.TrainNum1, Price5.TrainNum2, Price5.City, Price5.Price
      from Price5
      where Price5.SeatType = 'YW3'
),
p1_rw1(TrainNum1, TrainNum2, City, Price) as (
      select Price5.TrainNum1, Price5.TrainNum2, Price5.City, Price5.Price
      from Price5
      where Price5.SeatType = 'RW1'
),
p1_rw2(TrainNum1, TrainNum2, City, Price) as (
      select Price5.TrainNum1, Price5.TrainNum2, Price5.City, Price5.Price
      from Price5
      where Price5.SeatType = 'RW2'
),
p1(TrainNum1, TrainNum2, City, YZPrice, RZPrice, YW1Price, 
      YW2Price, YW3Price, RW1Price, RW2Price) as (
      select distinct 
            p1_yz.TrainNum1, p1_yz.TrainNum2, p1_yz.City, p1_yz.Price, p1_rz.Price,
            p1_yw1.Price, p1_yw2.Price, p1_yw3.Price,
            p1_rw1.Price, p1_rw2.Price
      from p1_yz
      full outer join p1_rz on p1_yz.TrainNum1 = p1_rz.TrainNum1 and p1_yz.TrainNum2 = p1_rz.TrainNum2 and p1_yz.City = p1_rz.City
      full outer join p1_yw1 on p1_yz.TrainNum1 = p1_yw1.TrainNum1 and p1_yz.TrainNum2 = p1_yw1.TrainNum2 and p1_yz.City = p1_yw1.City
      full outer join p1_yw2 on p1_yz.TrainNum1 = p1_yw2.TrainNum1 and p1_yz.TrainNum2 = p1_yw2.TrainNum2 and p1_yz.City = p1_yw2.City
      full outer join p1_yw3 on p1_yz.TrainNum1 = p1_yw3.TrainNum1 and p1_yz.TrainNum2 = p1_yw3.TrainNum2 and p1_yz.City = p1_yw3.City
      full outer join p1_rw1 on p1_yz.TrainNum1 = p1_rw1.TrainNum1 and p1_yz.TrainNum2 = p1_rw1.TrainNum2 and p1_yz.City = p1_rw1.City
      full outer join p1_rw2 on p1_yz.TrainNum1 = p1_rw2.TrainNum1 and p1_yz.TrainNum2 = p1_rw2.TrainNum2 and p1_yz.City = p1_rw2.City
),
Price3(TrainNum1, TrainNum2, City, SeatType, Price) as (                   -- T2 始发站到换乘站的票价
      select distinct 
            S4.S4_TrainNum1, S4.S4_TrainNum2, S4.S4_City,
            TicketPrice.TP_SeatType, TicketPrice.TP_Price
      from TicketPrice, S4, Train
      where Train.T_Number = S4.S4_TrainNum2 and
            Train.T_Station = S4.S4_Station2 and
            Train.T_Number = TicketPrice.TP_TrainNum and
            Train.T_StopNum = TicketPrice.TP_ArrivalNum
),
Price4(TrainNum1, TrainNum2, City, SeatType, Price) as (                            -- T2 始发站到到达站的票价
      select distinct
            S4.S4_TrainNum1, S4.S4_TrainNum2, S4.S4_City,
            TicketPrice.TP_SeatType, TicketPrice.TP_Price
      from TicketPrice, S4, Train, Station
      where Train.T_Number = S4.S4_TrainNum2 and
            Train.T_Station = Station.St_Name and
            Station.St_City = '$toCity' and
            Train.T_Number = TicketPrice.TP_TrainNum and
            Train.T_StopNum = TicketPrice.TP_ArrivalNum and
            TicketPrice.TP_Price != 0
),
Price6(TrainNum1, TrainNum2, City, SeatType, Price) as (
      select Price3.TrainNum1, Price3.TrainNum2, Price3.City,
            Price3.SeatType, Price4.Price - Price3.Price
      from Price3, Price4
      where Price3.TrainNum1 = Price4.TrainNum1 and
            Price3.TrainNum2 = Price4.TrainNum2 and
            Price3.City = Price4.City and
            Price3.SeatType = Price4.SeatType
),
p2_yz(TrainNum1, TrainNum2, City, Price) as (
      select Price6.TrainNum1, Price6.TrainNum2, Price6.City, Price6.Price
      from Price6
      where Price6.SeatType = 'YZ'
),
p2_rz(TrainNum1, TrainNum2, City, Price) as (
      select Price6.TrainNum1, Price6.TrainNum2, Price6.City, Price6.Price
      from Price6
      where Price6.SeatType = 'RZ'
),
p2_yw1(TrainNum1, TrainNum2, City, Price) as (
      select Price6.TrainNum1, Price6.TrainNum2, Price6.City, Price6.Price
      from Price6
      where Price6.SeatType = 'YW1'
),
p2_yw2(TrainNum1, TrainNum2, City, Price) as (
      select Price6.TrainNum1, Price6.TrainNum2, Price6.City, Price6.Price
      from Price6
      where Price6.SeatType = 'YW2'
),
p2_yw3(TrainNum1, TrainNum2, City, Price) as (
      select Price6.TrainNum1, Price6.TrainNum2, Price6.City, Price6.Price
      from Price6
      where Price6.SeatType = 'YW3'
),
p2_rw1(TrainNum1, TrainNum2, City, Price) as (
      select Price6.TrainNum1, Price6.TrainNum2, Price6.City, Price6.Price
      from Price6
      where Price6.SeatType = 'RW1'
),
p2_rw2(TrainNum1, TrainNum2, City, Price) as (
      select Price6.TrainNum1, Price6.TrainNum2, Price6.City, Price6.Price
      from Price6
      where Price6.SeatType = 'RW2'
),
p2(TrainNum1, TrainNum2, City, YZPrice, RZPrice, YW1Price, 
      YW2Price, YW3Price, RW1Price, RW2Price) as (
      select distinct
            p2_yz.TrainNum1, p2_yz.TrainNum2, p2_yz.City, p2_yz.Price, p2_rz.Price,
            p2_yw1.Price, p2_yw2.Price, p2_yw3.Price,
            p2_rw1.Price, p2_rw2.Price
      from p2_yz
      full outer join p2_rz on p2_yz.TrainNum1 = p2_rz.TrainNum1 and p2_yz.TrainNum2 = p2_rz.TrainNum2 and p2_yz.City = p2_rz.City
      full outer join p2_yw1 on p2_yz.TrainNum1 = p2_yw1.TrainNum1 and p2_yz.TrainNum2 = p2_yw1.TrainNum2 and p2_yz.City = p2_yw1.City
      full outer join p2_yw2 on p2_yz.TrainNum1 = p2_yw2.TrainNum1 and p2_yz.TrainNum2 = p2_yw2.TrainNum2 and p2_yz.City = p2_yw2.City
      full outer join p2_yw3 on p2_yz.TrainNum1 = p2_yw3.TrainNum1 and p2_yz.TrainNum2 = p2_yw3.TrainNum2 and p2_yz.City = p2_yw3.City
      full outer join p2_rw1 on p2_yz.TrainNum1 = p2_rw1.TrainNum1 and p2_yz.TrainNum2 = p2_rw1.TrainNum2 and p2_yz.City = p2_rw1.City
      full outer join p2_rw2 on p2_yz.TrainNum1 = p2_rw2.TrainNum1 and p2_yz.TrainNum2 = p2_rw2.TrainNum2 and p2_yz.City = p2_rw2.City
),
StaNum1(TrainNum, StopNum, Station) as (
      select distinct Train.T_Number, Train.T_StopNum, Train.T_Station
      from Train, S4, Station
      where Train.T_Number = S4.S4_TrainNum1 and
            Train.T_Station = Station.St_Name and
            Station.St_City = '$fromCity'
),
StaNum2(TrainNum, StopNum, City) as (
      select distinct Train.T_Number, Train.T_StopNum, S4.S4_City
      from Train, S4
      where Train.T_Number = S4.S4_TrainNum1 and
            Train.T_Station = S4.S4_Station1
),
StaNum3(TrainNum, StopNum, City) as (
      select distinct Train.T_Number, Train.T_StopNum, S4.S4_City
      from Train, S4
      where Train.T_Number = S4.S4_TrainNum2 and
            Train.T_Station = S4.S4_Station2
),
StaNum4(TrainNum, StopNum, Station) as (
      select distinct Train.T_Number, Train.T_StopNum, Train.T_Station
      from Train, S4, Station
      where Train.T_Number = S4.S4_TrainNum2 and
            Train.T_Station = Station.St_Name and
            Station.St_City = '$toCity'
),
Seat1(TrainNum1, TrainNum2, City, SeatType, TicketLeft) as (             -- 第一段的座位
      select S4.S4_TrainNum1, S4.S4_TrainNum2, S4.S4_City,
            Seat.Se_Type, MIN(Seat.Se_TicketLeft)
      from Train, S4, Seat, StaNum1, StaNum2
      where Train.T_Number = S4.S4_TrainNum1 and
            Train.T_Number = Seat.Se_TrainNum and
            Train.T_Number = StaNum1.TrainNum and
            Train.T_Number = StaNum2.TrainNum and
            Seat.Se_Date = '$date' and
            Train.T_StopNum = Seat.Se_StopNum and
            Train.T_StopNum > StaNum1.StopNum and
            Train.T_StopNum <= StaNum2.StopNum
      group by S4.S4_TrainNum1, S4.S4_TrainNum2, S4.S4_City, Seat.Se_Type
),
s1_yz(TrainNum1, TrainNum2, City, TicketLeft) as (
      select Seat1.TrainNum1, Seat1.TrainNum2, Seat1.City, Seat1.TicketLeft
      from Seat1
      where Seat1.SeatType = 'YZ'
),
s1_rz(TrainNum1, TrainNum2, City, TicketLeft) as (
      select Seat1.TrainNum1, Seat1.TrainNum2, Seat1.City, Seat1.TicketLeft
      from Seat1
      where Seat1.SeatType = 'RZ'
),
s1_yw1(TrainNum1, TrainNum2, City, TicketLeft) as (
      select Seat1.TrainNum1, Seat1.TrainNum2, Seat1.City, Seat1.TicketLeft
      from Seat1
      where Seat1.SeatType = 'YW1'
),
s1_yw2(TrainNum1, TrainNum2, City, TicketLeft) as (
      select Seat1.TrainNum1, Seat1.TrainNum2, Seat1.City, Seat1.TicketLeft
      from Seat1
      where Seat1.SeatType = 'YW2'
),
s1_yw3(TrainNum1, TrainNum2, City, TicketLeft) as (
      select Seat1.TrainNum1, Seat1.TrainNum2, Seat1.City, Seat1.TicketLeft
      from Seat1
      where Seat1.SeatType = 'YW3'
),
s1_rw1(TrainNum1, TrainNum2, City, TicketLeft) as (
      select Seat1.TrainNum1, Seat1.TrainNum2, Seat1.City, Seat1.TicketLeft
      from Seat1
      where Seat1.SeatType = 'RW1'
),
s1_rw2(TrainNum1, TrainNum2, City, TicketLeft) as (
      select Seat1.TrainNum1, Seat1.TrainNum2, Seat1.City, Seat1.TicketLeft
      from Seat1
      where Seat1.SeatType = 'RW2'
),
s11(TrainNum1, TrainNum2, City, YZTicketLeft, RZTicketLeft, 
      YW1TicketLeft, YW2TicketLeft, YW3TicketLeft,
      RW1TicketLeft, RW2TicketLeft) as (
      select distinct 
            s1_yz.TrainNum1, s1_yz.TrainNum2, s1_yz.City, 
            s1_yz.TicketLeft, s1_rz.TicketLeft,
            s1_yw1.TicketLeft, s1_yw2.TicketLeft, s1_yw3.TicketLeft,
            s1_rw1.TicketLeft, s1_rw2.TicketLeft
      from s1_yz
      full outer join s1_rz on s1_yz.TrainNum1 = s1_rz.TrainNum1 and s1_yz.TrainNum2 = s1_rz.TrainNum2 and s1_yz.City = s1_rz.City
      full outer join s1_yw1 on s1_yz.TrainNum1 = s1_yw1.TrainNum1 and s1_yz.TrainNum2 = s1_yw1.TrainNum2 and s1_yz.City = s1_yw1.City
      full outer join s1_yw2 on s1_yz.TrainNum1 = s1_yw2.TrainNum1 and s1_yz.TrainNum2 = s1_yw2.TrainNum2 and s1_yz.City = s1_yw2.City
      full outer join s1_yw3 on s1_yz.TrainNum1 = s1_yw3.TrainNum1 and s1_yz.TrainNum2 = s1_yw3.TrainNum2 and s1_yz.City = s1_yw3.City
      full outer join s1_rw1 on s1_yz.TrainNum1 = s1_rw1.TrainNum1 and s1_yz.TrainNum2 = s1_rw1.TrainNum2 and s1_yz.City = s1_rw1.City
      full outer join s1_rw2 on s1_yz.TrainNum1 = s1_rw2.TrainNum1 and s1_yz.TrainNum2 = s1_rw2.TrainNum2 and s1_yz.City = s1_rw2.City
),
Seat2(TrainNum1, TrainNum2, City, SeatType, TicketLeft) as (             -- 第二段的座位
      select S4.S4_TrainNum1, S4.S4_TrainNum2, S4.S4_City, 
            Seat.Se_Type, MIN(Seat.Se_TicketLeft)
      from Train, S4, Seat, StaNum3, StaNum4
      where Train.T_Number = S4.S4_TrainNum1 and
            Train.T_Number = Seat.Se_TrainNum and
            Train.T_Number = StaNum3.TrainNum and
            Train.T_Number = StaNum4.TrainNum and
            Seat.Se_Date = '$date' and
            Train.T_StopNum = Seat.Se_StopNum and
            Train.T_StopNum > StaNum3.StopNum and
            Train.T_StopNum <= StaNum4.StopNum
      group by S4.S4_TrainNum1, S4.S4_TrainNum2, S4.S4_City, Seat.Se_Type
),
s2_yz(TrainNum1, TrainNum2, City, TicketLeft) as (
      select Seat2.TrainNum1, Seat2.TrainNum2, Seat2.City, Seat2.TicketLeft
      from Seat2
      where Seat2.SeatType = 'YZ'
),
s2_rz(TrainNum1, TrainNum2, City, TicketLeft) as (
      select Seat2.TrainNum1, Seat2.TrainNum2, Seat2.City, Seat2.TicketLeft
      from Seat2
      where Seat2.SeatType = 'RZ'
),
s2_yw1(TrainNum1, TrainNum2, City, TicketLeft) as (
      select Seat2.TrainNum1, Seat2.TrainNum2, Seat2.City, Seat2.TicketLeft
      from Seat2
      where Seat2.SeatType = 'YW1'
),
s2_yw2(TrainNum1, TrainNum2, City, TicketLeft) as (
      select Seat2.TrainNum1, Seat2.TrainNum2, Seat2.City, Seat2.TicketLeft
      from Seat2
      where Seat2.SeatType = 'YW2'
),
s2_yw3(TrainNum1, TrainNum2, City, TicketLeft) as (
      select Seat2.TrainNum1, Seat2.TrainNum2, Seat2.City, Seat2.TicketLeft
      from Seat2
      where Seat2.SeatType = 'YW3'
),
s2_rw1(TrainNum1, TrainNum2, City, TicketLeft) as (
      select Seat2.TrainNum1, Seat2.TrainNum2, Seat2.City, Seat2.TicketLeft
      from Seat2
      where Seat2.SeatType = 'RW1'
),
s2_rw2(TrainNum1, TrainNum2, City, TicketLeft) as (
      select Seat2.TrainNum1, Seat2.TrainNum2, Seat2.City, Seat2.TicketLeft
      from Seat2
      where Seat2.SeatType = 'RW2'
),
s22(TrainNum1, TrainNum2, City, YZTicketLeft, RZTicketLeft, 
      YW1TicketLeft, YW2TicketLeft, YW3TicketLeft,
      RW1TicketLeft, RW2TicketLeft) as (
      select distinct 
            s2_yz.TrainNum1, s2_yz.TrainNum2, s2_yz.City, 
            s2_yz.TicketLeft, s2_rz.TicketLeft,
            s2_yw1.TicketLeft, s2_yw2.TicketLeft, s2_yw3.TicketLeft,
            s2_rw1.TicketLeft, s2_rw2.TicketLeft
      from s2_yz
      full outer join s2_rz on s2_yz.TrainNum1 = s2_rz.TrainNum1 and s2_yz.TrainNum2 = s2_rz.TrainNum2 and s2_yz.City = s2_rz.City
      full outer join s2_yw1 on s2_yz.TrainNum1 = s2_yw1.TrainNum1 and s2_yz.TrainNum2 = s2_yw1.TrainNum2 and s2_yz.City = s2_yw1.City
      full outer join s2_yw2 on s2_yz.TrainNum1 = s2_yw2.TrainNum1 and s2_yz.TrainNum2 = s2_yw2.TrainNum2 and s2_yz.City = s2_yw2.City
      full outer join s2_yw3 on s2_yz.TrainNum1 = s2_yw3.TrainNum1 and s2_yz.TrainNum2 = s2_yw3.TrainNum2 and s2_yz.City = s2_yw3.City
      full outer join s2_rw1 on s2_yz.TrainNum1 = s2_rw1.TrainNum1 and s2_yz.TrainNum2 = s2_rw1.TrainNum2 and s2_yz.City = s2_rw1.City
      full outer join s2_rw2 on s2_yz.TrainNum1 = s2_rw2.TrainNum1 and s2_yz.TrainNum2 = s2_rw2.TrainNum2 and s2_yz.City = s2_rw2.City
),
Time1(TrainNum, DTime) as (
    select Train.T_Number, Train.T_DepartureTime
    from Train, StaNum1
    where Train.T_Number = StaNum1.TrainNum and
          Train.T_StopNum = StaNum1.StopNum
),
Time2(TrainNum, ATime) as (
    select Train.T_Number, Train.T_ArrivalTime
    from Train, StaNum4
    where Train.T_Number = StaNum4.TrainNum and
          Train.T_StopNum = StaNum4.StopNum
),
Time3(TrainNum1, TrainNum2, City, t) as (
      select distinct 
            S4.S4_TrainNum1, S4.S4_TrainNum2, S4.S4_City,
            S1.S1_Time - Time1.DTime
      from S4, S1, Time1
      where S4.S4_TrainNum1 = S1.S1_TrainNum and
            S4.S4_City = S1.S1_City and
            S4.S4_TrainNum1 = Time1.TrainNum
),
Time4(TrainNum1, TrainNum2, City, t) as (
      select distinct
            S4.S4_TrainNum1, S4.S4_TrainNum2, S4.S4_City,
            Time2.ATime - S2.S2_Time
      from S4, S2, Time2
      where S4.S4_TrainNum2 = S2.S2_TrainNum and
            S4.S4_City = S2.S2_City and
            S4.S4_TrainNum2 = Time2.TrainNum
),
TotalTime(TrainNum1, TrainNum2, TotalTime) as (
    select distinct
            S4.S4_TrainNum1, S4.S4_TrainNum2,
            Time3.t + S4.S4_Time + Time4.t
    from S4, Time3, Time4
    where S4.S4_TrainNum1 = Time3.TrainNum1 and
          S4.S4_TrainNum2 = Time3.TrainNum2 and
          S4.S4_TrainNum1 = Time4.TrainNum1 and
          S4.S4_TrainNum2 = Time4.TrainNum2 and
          Time3.City = Time4.City
)
select distinct S4.S4_TrainNum1 as TrainNum1,
                S4.S4_TrainNum2 as TrainNum2,
                Time1.DTime as DepartureTime,
                StaNum1.Station as Station1,
                S1.S1_Time as TransferTime1,
                S1.S1_Station as Station2,
                S2.S2_Time as TransferTime2,
                S2.S2_Station as Station3,
                Time2.ATime as ArrivalTime,
                StaNum4.Station as Station4,
                TotalTime.TotalTime as TotalTime,
                S4.S4_Time as TransferTime,
                p1.YZPrice as YZPrice1,
                s11.YZTicketLeft as YZTicketLeft1,
                p1.RZPrice as RZPrice1,
                s11.RZTicketLeft as RZTicketLeft1,
                p1.YW1Price as YW1Price1,
                s11.YW1TicketLeft as YW1TicketLeft1,
                p1.YW2Price as YW2Price1,
                s11.YW2TicketLeft as YW2TicketLeft1,
                p1.YW3Price as YW3Price1,
                s11.YW3TicketLeft as YW3TicketLeft1,
                p1.RW1Price as RW1Price1,
                s11.RW1TicketLeft as RW1TicketLeft1,
                p1.RW2Price as RW2Price1,
                s11.RW2TicketLeft as RW2TicketLeft1,
                p2.YZPrice as YZPrice2,
                s22.YZTicketLeft as YZTicketLeft2,
                p2.RZPrice as RZPrice2,
                s22.RZTicketLeft as RZTicketLeft2,
                p2.YW1Price as YW1Price2,
                s22.YW1TicketLeft as YW1TicketLeft2,
                p2.YW2Price as YW2Price2,
                s22.YW2TicketLeft as YW2TicketLeft2,
                p2.YW3Price as YW3Price2,
                s22.YW3TicketLeft as YW3TicketLeft2,
                p2.RW1Price as RW1Price2,
                s22.RW1TicketLeft as RW1TicketLeft2,
                p2.RW2Price as RW2Price2,
                s22.RW2TicketLeft as RW2TicketLeft2
from S4, Time1, Time2, S1, S2, StaNum1, StaNum4, TotalTime, p1, p2, s11, s22
where S4.S4_TrainNum1 = Time1.TrainNum and
      S4.S4_TrainNum2 = Time2.TrainNum and

      S4.S4_TrainNum1 = StaNum1.TrainNum and
      S4.S4_TrainNum2 = StaNum4.TrainNum and

      S4.S4_TrainNum1 = S1.S1_TrainNum and
      S4.S4_TrainNum2 = S2.S2_TrainNum and
      S1.S1_City = S2.S2_City and

      S4.S4_TrainNum1 = TotalTime.TrainNum1 and
      S4.S4_TrainNum2 = TotalTime.TrainNum2 and

      S4.S4_TrainNum1 = p1.TrainNum1 and
      S4.S4_TrainNum2 = p1.TrainNum2 and 
      S4.S4_City = p1.City and

      S4.S4_TrainNum1 = p2.TrainNum1 and
      S4.S4_TrainNum2 = p2.TrainNum2 and 
      S4.S4_City = p2.City and

      S4.S4_TrainNum1 = s11.TrainNum1 and
      S4.S4_TrainNum2 = s11.TrainNum2 and 
      S4.S4_City = s11.City and

      S4.S4_TrainNum1 = s22.TrainNum1 and
      S4.S4_TrainNum2 = s22.TrainNum2 and 
      S4.S4_City = s22.City
order by TotalTime.TotalTime, Time1.DTime
limit 10;

SQL;
        $res = Database::selectAll($sql);
        // var_dump($res);

        foreach ($res as $row) {
            $leftTicket = new LeftTicket();
            $leftTicket->initCityTransferRow($row, $date);
            $this->list []= $leftTicket;
        }
    }
}