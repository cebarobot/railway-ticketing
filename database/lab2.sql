-- create database ticketing owner ticketing;

create type se_type as enum (
	'YZ', 'RZ', 'YW1', 'YW2', 'YW3', 'RW1', 'RW2'
);

create type o_status as enum (
	'reserved', 'cancelled'
);

create table MyUser (
    U_UserName      varchar(20) primary key,    -- 用户名，主键
    U_Name          varchar(20) not null,       -- 姓名
    U_ID            char(18) not null unique,   -- 身份证号，添加唯一约束
    U_PhoneNum      char(11) not null,          -- 电话号码
    U_CreditCard    char(16) not null           -- 信用卡号
);

create table Station   (
    St_Name varchar(10) primary key,            -- 车站名称
    St_City varchar(10) not null                -- 车站所在城市
);

create table Train (
    T_Number        varchar(6) not null,        -- 车次
    T_StopNum       integer not null,           -- 经停站序号
    T_Station       varchar(10) not null,       -- 经停站名称
    T_ArrivalTime   interval,                   -- 到达该经停站时间
    T_DepartureTime interval,                   -- 离开该经停站时间
    primary key     (T_Number, T_StopNum),
    foreign key     (T_Station) references Station(St_Name)
);

create table OrderInfo (
    O_ID            serial primary key,         -- 订单编号
    O_TrainNum      varchar(6) not null,        -- 车次
    O_TrainDate     date not null,              -- 车次日期
    O_Time          timestamp not null,         -- 订单时间
    O_SeatType      se_type not null,           -- 坐席类别
    O_DepartureNum  integer not null,           -- 出发站编号
    O_ArrivalNum    integer not null,           -- 终到站编号
    O_Price         float not null,             -- 车票价格
    O_Status        o_status not null,          -- 订单状态
    O_UserName      varchar(20) not null,       -- 订单用户
    foreign key (O_TrainNum, O_ArrivalNum) references Train(T_Number, T_StopNum),
    foreign key (O_UserName) references MyUser(U_UserName)
);

create table TicketPrice (
    TP_TrainNum     varchar(6) not null,        -- 车次
    TP_ArrivalNum   integer not null,           -- 到达站序号
    TP_SeatType     se_type not null,           -- 坐席类别
    TP_Price        float not null,             -- 始发站到此站的票价
    primary key     (TP_TrainNum, TP_ArrivalNum, TP_SeatType),
    foreign key     (TP_TrainNum, TP_ArrivalNum) references Train(T_Number, T_StopNum)
);

create table Seat  (
    Se_TrainNum     varchar(6) not null,        -- 车次
    Se_Date         date not null,              -- 车次日期
    Se_Type         se_type not null,           -- 坐席类别
    Se_StopNum      integer not null,           -- 区间结束的经停站序号
    Se_TicketLeft   integer,                    -- 上一站至本站区间的余票数量
    primary key     (Se_TrainNum, Se_Date, Se_Type, Se_StopNum),
    foreign key     (Se_TrainNum, Se_StopNum) references Train(T_Number, T_StopNum)
);
