<?php 
namespace app\controllers;

use app\models\Auth;

class AuthCtrl {
    static public function logout() {
        Auth::logout();
        header("Location: /");
        die();
    }
}