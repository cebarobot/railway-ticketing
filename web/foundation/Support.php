<?php

namespace foundation;

class Support {
    public static function includeView($name, $params = array()) {
        extract($params);
        include PHP_BASE_DIR.'/app/views/'.$name.'.php';
    }
    public static function errorPageNotFound() {
        http_response_code(404);
        die();
    }
}