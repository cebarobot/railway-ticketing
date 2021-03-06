<?php
namespace app\models;

class Symbol {
    public static $seatTypeMap = array(
        'YZ' => '硬座',
        'RZ' => '软座',
        'YW1' => '硬卧 上铺',
        'YW2' => '硬卧 中铺',
        'YW3' => '硬卧 下铺',
        'RW1' => '软卧 上铺',
        'RW2' => '软卧 下铺',
    );

    public static function seatType($str) {
        return self::$seatTypeMap[$str];
    }

    private static $statusMap = array(
        'reserved' => '已完成',
        'cancelled' => '已取消',
    );

    public static function status($str) {
        return self::$statusMap[$str];
    }
}