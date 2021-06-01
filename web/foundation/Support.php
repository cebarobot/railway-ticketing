<?php

namespace foundation;

class Support {
    public static $weekStr = array(
        '星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六', 
    );
    public static function includeView($name, $params = array()) {
        extract($params);
        include PHP_BASE_DIR.'/app/views/'.$name.'.php';
    }
    public static function errorPageNotFound() {
        http_response_code(404);
        self::includeView('error404');
        die();
    }
	public static function getRequestPath($uri) {
		$p = strpos($uri, '?');
		if ($p === false) {
			return $uri;
		} else {
			return substr($uri, 0, $p);
		}
	}
    public static function getWeekStr($w) {
        return self::$weekStr[$w];
    }
}