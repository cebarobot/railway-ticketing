<?php

namespace app\controllers;

use foundation\Support;
use foundation\Session;

use app\models\User;
use app\models\Auth;
use app\models\Order;
use app\models\Ticket;

class StaticPage {
    public static function index() {
        Support::includeView("index");
        die();
    }

};