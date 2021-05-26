<?php
namespace foundation;

class Session {
	public static function init() {
		session_name('PHPSESSID');
		ini_set('session.cookie_path', '/');
		ini_set('session.cookie_domain', '');
		
		session_start();
		
		register_shutdown_function(function() {
			if (empty($_SESSION)) {
				session_unset();
				session_destroy();
			}
		});
	}

    public static function set($name, $value) {
        $_SESSION[$name] = $value;
    }

    public static function unset($name) {
        unset($_SESSION[$name]);
    }

    public static function get($name) {
        return $_SESSION[$name];
    }

    public static function isSet($name) {
        return isset($_SESSION[$name]);
    }
}