<?php
namespace app\models;

use foundation\Database;

class AllLeftTicketsCity extends \foundation\BaseModel {
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
T1(T1_Number, T1_StopNum) as (            -- 列车经过出发地
    select Train.T_Number, Train.T_StopNum
    from Train, Station
    where Train.T_Station = Station.St_Name and
          Station.St_City = '$fromCity'
),
T2(T2_Number, T2_StopNum) as (            -- 列车经过到达地
    select Train.T_Number, Train.T_StopNum
    from Train, Station
    where Train.T_Station = Station.St_Name and
          Station.St_City = '$toCity'
),
T_Nonstop1(TN1_Number) as (               -- 列车从出发地到到达地（直达）
    select T1.T1_Number
    from T1, T2
    where T1.T1_Number = T2.T2_Number and
          T1.T1_StopNum < T2.T2_StopNum
),
T_Nonstop2(TN2_Number) as (               -- 列车满足出发时间
    select T_Nonstop1.TN1_Number
    from T_Nonstop1, Train, Station
    where T_Nonstop1.TN1_Number = Train.T_Number and
          Train.T_Station = Station.St_Name and
          Station.St_City = '$fromCity' and
          Train.T_DepartureTime >= '$time'
),
T_Price1(TP1_TrainNum, TP1_SeatType, TP1_Price) as (        -- 始发站到出发地的票价
      select T_Nonstop2.TN2_Number, TicketPrice.TP_SeatType, TicketPrice.TP_Price
      from T_Nonstop2, Train, Station, TicketPrice
      where Train.T_Number = T_Nonstop2.TN2_Number and
            Station.St_City = '$fromCity' and
            Train.T_Station = Station.St_Name and
            TicketPrice.TP_TrainNum = Train.T_Number and
            TicketPrice.TP_ArrivalNum = Train.T_StopNum
),
T_Price2(TP2_TrainNum, TP2_SeatType, TP2_Price) as (        -- 始发站到到达地的票价
      select T_Nonstop2.TN2_Number, TicketPrice.TP_SeatType, TicketPrice.TP_Price
      from T_Nonstop2, Train, Station, TicketPrice
      where Train.T_Number = T_Nonstop2.TN2_Number and
            Station.St_City = '$toCity' and
            Train.T_Station = Station.St_Name and
            TicketPrice.TP_TrainNum = Train.T_Number and
            TicketPrice.TP_ArrivalNum = Train.T_StopNum and 
            TicketPrice.TP_Price != 0
),
T_Price(TP_TrainNum, TP_SeatType, TP_Price) as (            -- 出发地到到达地的票价
      select T_Price1.TP1_TrainNum, T_Price1.TP1_SeatType, 
             T_Price2.TP2_Price - T_Price1.TP1_Price
      from T_Price1, T_Price2
      where T_Price1.TP1_TrainNum = T_Price2.TP2_TrainNum and
            T_Price1.TP1_SeatType = T_Price2.TP2_SeatType
),
T_StaNum1(TSN1_TrainNum, TSN1_StopNum, TSN1_Station) as (               -- 列车在出发地车站的序号
      select Train.T_Number, Train.T_StopNum, Train.T_Station
      from Train, T_Nonstop2, Station
      where Train.T_Number = T_Nonstop2.TN2_Number and
            Train.T_Station = Station.St_Name and
            Station.St_City = '$fromCity'
),
T_StaNum2(TSN2_TrainNum, TSN2_StopNum, TSN2_Station) as (               -- 列车在到达地车站的序号
      select Train.T_Number, Train.T_StopNum, Train.T_Station
      from Train, T_Nonstop2, Station
      where Train.T_Number = T_Nonstop2.TN2_Number and
            Train.T_Station = Station.St_Name and
            Station.St_City = '$toCity'
),
T_Seat(TS_TrainNum, TS_SeatType, TS_TicketLeft) as (        -- 列车在行程中的余票
      select T_Nonstop2.TN2_Number, Seat.Se_Type,
             MIN(Seat.Se_TicketLeft)
      from Train, T_StaNum1, T_StaNum2, Seat, T_Nonstop2
      where Train.T_Number = T_Nonstop2.TN2_Number and
            Train.T_Number = T_StaNum1.TSN1_TrainNum and
            Train.T_Number = T_StaNum2.TSN2_TrainNum and
            Train.T_Number = Seat.Se_TrainNum and
            Seat.Se_Date = '$date' and
            Train.T_StopNum = Seat.Se_StopNum and
            Train.T_StopNum > T_StaNum1.TSN1_StopNum and
            Train.T_StopNum <= T_StaNum2.TSN2_StopNum
      group by T_Nonstop2.TN2_Number, Seat.Se_Type
),
T_SeatInfo(TSI_TrainNum, TSI_SeatType, TSI_Price, TSI_TicketLeft) as (        -- 余票数不为 0 的座位信息
      select T_Seat.TS_TrainNum, T_Seat.TS_SeatType, 
             T_Price.TP_Price, T_Seat.TS_TicketLeft
      from T_Seat, T_Price
      where T_Seat.TS_TrainNum = T_Price.TP_TrainNum and
            T_Seat.TS_SeatType = T_Price.TP_SeatType and
            T_Seat.TS_TicketLeft != 0
),
T_Time1(TT1_TrainNum, TT1_Time) as (                              -- 列车离开出发车站的时间
      select Train.T_Number, Train.T_DepartureTime
      from Train, T_StaNum1
      where Train.T_Number = T_StaNum1.TSN1_TrainNum and
            Train.T_StopNum = T_StaNum1.TSN1_StopNum
),
T_Time2(TT2_TrainNum, TT2_Time) as (                              -- 列车到达终点车站的时间
      select Train.T_Number, Train.T_ArrivalTime
      from Train, T_StaNum2
      where Train.T_Number = T_StaNum2.TSN2_TrainNum and
            Train.T_StopNum = T_StaNum2.TSN2_StopNum
),
T_Time(TT_TrainNum, TT_Time) as (                                 -- 旅途用时
      select T_Time1.TT1_TrainNum,
             T_Time2.TT2_Time - T_Time1.TT1_Time
      from T_Time1, T_Time2
      where T_Time1.TT1_TrainNum = T_Time2.TT2_TrainNum
),
Res(TrainNum, DepartureSta, DepartureTime, 
      ArrivalSta, ArrivalTime, TotalTime, 
      SeatType, Price, TicketLeft) as (

      select distinct T_SeatInfo.TSI_TrainNum, 
                      T_StaNum1.TSN1_Station,
                      T_Time1.TT1_Time,
                      T_StaNum2.TSN2_Station,
                      T_Time2.TT2_Time,
                      T_Time.TT_Time,
                      T_SeatInfo.TSI_SeatType,
                      T_SeatInfo.TSI_Price,
                      T_SeatInfo.TSI_TicketLeft
      from T_StaNum1, T_StaNum2, T_SeatInfo, T_Time1, T_Time2, T_Time
      where T_SeatInfo.TSI_Price != 0 and
            T_SeatInfo.TSI_TrainNum = T_StaNum1.TSN1_TrainNum and
            T_SeatInfo.TSI_TrainNum = T_StaNum2.TSN2_TrainNum and
            T_SeatInfo.TSI_TrainNum = T_Time1.TT1_TrainNum and
            T_SeatInfo.TSI_TrainNum = T_Time2.TT2_TrainNum and
            T_SeatInfo.TSI_TrainNum = T_Time.TT_TrainNum

),
yz(TrainNum, Price, TicketLeft) as (
      select Res.TrainNum, Res.Price, Res.TicketLeft
      from Res
      where Res.SeatType = 'YZ'
),
rz(TrainNum, Price, TicketLeft) as (
      select Res.TrainNum, Res.Price, Res.TicketLeft
      from Res
      where Res.SeatType = 'RZ'
),
yw1(TrainNum, Price, TicketLeft) as (
      select Res.TrainNum, Res.Price, Res.TicketLeft
      from Res
      where Res.SeatType = 'YW1'
),
yw2(TrainNum, Price, TicketLeft) as (
      select Res.TrainNum, Res.Price, Res.TicketLeft
      from Res
      where Res.SeatType = 'YW2'
),
yw3(TrainNum, Price, TicketLeft) as (
      select Res.TrainNum, Res.Price, Res.TicketLeft
      from Res
      where Res.SeatType = 'YW3'
),
rw1(TrainNum, Price, TicketLeft) as (
      select Res.TrainNum, Res.Price, Res.TicketLeft
      from Res
      where Res.SeatType = 'RW1'
),
rw2(TrainNum, Price, TicketLeft) as (
      select Res.TrainNum, Res.Price, Res.TicketLeft
      from Res
      where Res.SeatType = 'RW2'
)
select distinct 
      Res.TrainNum as TrainNum, 
      Res.DepartureSta as DepartureSta, 
      Res.DepartureTime as DepartureTime, 
      Res.ArrivalSta as ArrivalSta, 
      Res.ArrivalTime as ArrivalTime, 
      Res.TotalTime as TotalTime, 
      yz.Price as YZPrice, 
      yz.TicketLeft as YZTicketLeft,
      rz.Price as RZPrice,
      rz.TicketLeft as RZTicketLeft,
      yw1.Price as YW1Price,
      yw1.TicketLeft as YW1TicketLeft,
      yw2.Price as YW2Price,
      yw2.TicketLeft as YW2TicketLeft,
      yw3.Price as YW3Price,
      yw3.TicketLeft as YW3TicketLeft,
      rw1.Price as RW1Price,
      rw1.TicketLeft as RW1TicketLeft,
      rw2.Price as RW2Price,
      rw2.TicketLeft as RW2TicketLeft
from Res 
full outer join yz on Res.TrainNum = yz.TrainNum
full outer join rz on Res.TrainNum = rz.TrainNum
full outer join yw1 on Res.TrainNum = yw1.TrainNum
full outer join yw2 on Res.TrainNum = yw2.TrainNum
full outer join yw3 on Res.TrainNum = yw3.TrainNum
full outer join rw1 on Res.TrainNum = rw1.TrainNum
full outer join rw2 on Res.TrainNum = rw2.TrainNum
order by yz.Price, yw1.Price, Res.TotalTime, Res.DepartureTime;

SQL;
        // var_dump($sql);
        $res = Database::selectAll($sql);
        // var_dump($res);

        $this->list = array();

        foreach ($res as $row) {
            $leftTicket = new LeftTicket();
            $leftTicket->initCityRow($row, $date);
            $this->list []= $leftTicket;
        }
    }
}