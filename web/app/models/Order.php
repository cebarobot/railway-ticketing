<?php
namespace app\models;

class Order extends \foundation\BaseModel {
    public $orderID;
    public $orderDate;
    public $status;
    public $ticketList;

    public function query() {
        
    }
}