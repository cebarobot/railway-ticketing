<?php
namespace app\models;
use foundation\Session;
use app\models\User;

class Auth {
    private static $currentUser;

    public static function check() {
        return self::$currentUser != null;
    }

    public static function user() {
        return self::$currentUser;
    }

    public static function init() {
        if (Session::isSet('userName')) {
            self::$currentUser = new User;
            if (!self::$currentUser->readFromDatabase(Session::get('userName'))) {
                Session::unset('userName');
                self::$currentUser = null;
            }
        } else {
            self::$currentUser = null;
        }
    }

    public static function login($userName) {
        self::$currentUser = new User;
        if (self::$currentUser->readFromDatabase($userName)) {
            Session::set('userName', $userName);
            return true;
        }
        Session::unset('userName');
        self::$currentUser = null;
        return false;
    }

    public static function logout() {
        Session::unset('userName');
        self::$currentUser = null;
    }
}