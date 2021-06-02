<?php 
namespace app\controllers;

use app\models\Auth;
use app\models\User;
use foundation\Database;
use foundation\Support;

class AuthCtrl {
    public static function logout() {
        Auth::logout();
        header("Location: /login");
        die();
    }

    public static function login() {
        $loginUserName = $_POST['username'] ?? '';
        if (Auth::login($loginUserName)) {
            header("Location: /");
        } else {
            Support::includeView('login', array('isInvalid' => true, 'loginUserName' => $loginUserName));
        }
        die();
    }

    public static function loginPage() {
        if (Auth::check()) {
            header("Location: /");
        } else {
            Support::includeView('login');
        }
        die();
    }

    public static function register() {
        $newUser = new User;
        $newUser->userName = $_POST['username'] ?? '';
        $newUser->name = $_POST['name'] ?? '';
        $newUser->id = $_POST['id'] ?? '';
        $newUser->phoneNum = $_POST['phone'] ?? '';
        $newUser->creditCard = $_POST['credit-card'] ?? '';

        if (!$newUser->validate()) {
            header("Location: /register");
            // echo "invalid";
            die();
        } else if ($newUser->exist()) {
            header("Location: /register");
            // echo "exist";
            die();
        } else {
            $newUser->storeToDatabase();
            header("Location: /login");
            die();
        }
    }

    public static function registerPage() {
        if (Auth::check()) {
            header("Location: /");
        } else {
            Support::includeView('register');
        }
        die();
    }
}