<?php

namespace foundation;


class Database {
    private static $pgConnection;
    private static $pgConnectionString = "dbname=ticketing user=ticketing password=ticketing host=localhost";

    public static function init() {
        self::$pgConnection = pg_connect(self::$pgConnectionString)
            or die("There is something wrong with database...");
    }

    public static function escape($string) {
        return pg_escape_string(self::$pgConnection, $string);
    }

    public static function query($querySQL) {
        return pg_query(self::$pgConnection, $querySQL);
    }
}