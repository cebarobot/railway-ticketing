<?php

class Loader {
    public static $belongMap = array(
        'app' => PHP_BASE_DIR. '/app',
        'foundation' => PHP_BASE_DIR . '/foundation',
    );

    public static function autoload($className) {
        $fileName = self::getFileName($className);
        include_once $fileName;
    }

    private static function getFileName($className) {
        $belong = substr($className, 0, strpos($className, '\\'));
        $belongDir = self::$belongMap[$belong];
        $fileName = substr($className, strlen($belong)) . '.php';
        return strtr($belongDir . $fileName, '\\', '/');
    }
}