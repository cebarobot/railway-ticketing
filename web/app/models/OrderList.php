<?php
namespace app\models;

use foundation\Database;

class OrderList {
    public $list;

    public function query($all = false) {
        $allOrders = Order::queryOfUser(Auth::user());
        $this->list = array();
        foreach ($allOrders as $oneOrder) {
            $thisOrder = new Order();
            $thisOrder->initFromOrderRow($oneOrder);
            $this->list []= $thisOrder;
        }
    }
}