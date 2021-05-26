<?php

namespace app\models;

use foundation\Database;

class User {
    public $userName;
    public $name;
    public $id;
    public $phoneNum;
    public $creditCard;

    public static function validateUserName($userName) {
        return is_string($userName) && preg_match('/^[A-Za-z_][a-zA-Z0-9_]{3,20}$/', $userName);
    }

    public static function validateId($id) {
        return is_string($id) && preg_match('/^[0-9]{17}[0-9xX]$/', $id);
    }

    public static function validatePhoneNum($phoneNum) {
        return is_string($phoneNum) && preg_match('/^[0-9]{11}$/', $phoneNum);
    }

    public function validate() {
        return self::validateUserName($this->userName) &&
            self::validateId($this->id) &&
            self::validatePhoneNum($this->phoneNum) &&
            !empty($this->name) && !empty($this->creditCard);
    }

    public function readFromDatabase($userName) {
        $result = Database::selectFirst("select * from MyUser where U_UserName = '$userName'");
        var_dump($result);
        if ($result) {
            $this->userName = $result[strtolower('U_UserName')];
            $this->name = $result[strtolower('U_Name')];
            $this->id = $result[strtolower('U_ID')];
            $this->phoneNum = $result[strtolower('U_PhoneNum')];
            $this->creditCard = $result[strtolower('U_CreditCard')];
            return true;
        }
        return false;
    }

    public function storeToDatabase($isUpdate = false) {
        if ($this->validate()) {
            $data = array(
                'U_Name' => $this->name,
                'U_ID' => $this->id,
                'U_PhoneNum' => $this->phoneNum,
                'U_CreditCard' => $this->creditCard,
            );
            if ($isUpdate) {
                $cond = array(
                    'U_UserName' => $this->userName
                );

                Database::updateOne('MyUser', $data, $cond);
            } else {
                $data['U_UserName'] = $this->userName;

                Database::insertOne('MyUser', $data);
            }
            return true;
        }
        return false;
    }
}