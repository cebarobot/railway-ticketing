<?php 
namespace app\controllers;

use app\models\Auth;
use foundation\Support;

class AuthCtrl {
    static public function logout() {
        Auth::logout();
        header("Location: /login");
        die();
    }

    static public function login() {
        $loginUserName = $_POST['username'] ?? '';
        if (Auth::login($loginUserName)) {
            header("Location: /");
        } else {
            Support::includeView('login', array('isInvalid' => true, 'loginUserName' => $loginUserName));
        }
        die();
    }

    static public function loginPage() {
        if (Auth::check()) {
            header("Location: /");
        } else {
            Support::includeView('login');
        }
        die();
    }
}