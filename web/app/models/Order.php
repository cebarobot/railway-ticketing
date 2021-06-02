<?php
namespace app\models;

class Order {
    public $orderID;
    public $orderDate;
    public $status;
    public $ticketList;

    function __construct($param) {
        $this->orderID = $param['orderID'] ?? null;
        $this->orderDate = $param['orderDate'] ?? null;
        $this->status = $param['status'] ?? null;
        $this->ticketList = $param['ticketList'] ?? null;
    }

    public function query() {
        
    }
}