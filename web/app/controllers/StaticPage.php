<?php

namespace app\controllers;
use foundation\Support;
use app\models\User;
use app\models\Auth;
use foundation\Session;

class StaticPage {
    public static function index() {
        Support::includeView("index");
        die();
    }

    public static function leftTickets() {
        Support::includeView("leftTickets");
        die();
    }
};