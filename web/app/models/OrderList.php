<?php
namespace app\models;

use foundation\Database;

class OrderList {
    public $list;

    public function queryAll() {
        $allOrders = Order::queryAll();
        $this->list = array();
        foreach ($allOrders as $oneOrder) {
            $thisOrder = new Order();
            $thisOrder->initFromOrderRow($oneOrder);
            $this->list []= $thisOrder;
        }
    }

    public function queryOfUser($user) {
        $allOrders = Order::queryOfUser($user);
        $this->list = array();
        foreach ($allOrders as $oneOrder) {
            $thisOrder = new Order();
            $thisOrder->initFromOrderRow($oneOrder);
            $this->list []= $thisOrder;
        }
    }
}