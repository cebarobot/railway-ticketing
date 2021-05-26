<?php

namespace app\controllers;
use foundation\Support;

class Index {
    public static function index() {
        Support::includeView("index", array("asdf" => "2333"));
    }
};