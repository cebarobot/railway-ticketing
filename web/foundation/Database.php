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
    
	public static function selectFirst($querySQL, $opt = PGSQL_ASSOC) {
		return pg_fetch_array(pg_query(self::$pgConnection, $querySQL), 0, $opt);
    }

    public static function updateOne($table, $data, $cond) {
        $sql = "update $table ";
        $setList = "";
        foreach ($data as $list => $value) {
            $listEscape = self::escape($list);
            $valueEscape = self::escape($value);
            $setList .= "$listEscape = '$valueEscape', ";
        }
        $setList = substr($setList, 0, -2);

        $whereList = "";
        foreach ($cond as $list => $value) {
            $listEscape = self::escape($list);
            $valueEscape = self::escape($value);
            $whereList .= "$listEscape = '$valueEscape' and ";
        }
        $whereList = substr($whereList, 0, -5);

        $sql .= "set $setList where $whereList;";

        // var_dump($sql);
        self::query($sql);
    }

    public static function insertOne($table, $data) {
        $sql = "insert into $table ";
        $listList = "";
        $valueList = "";
        foreach ($data as $list => $value) {
            $listEscape = self::escape($list);
            $valueEscape = self::escape($value);
            $listList .= "$listEscape, ";
            $valueList .= "'$valueEscape', ";
        }
        $listList = substr($listList, 0, -2);
        $valueList = substr($valueList, 0, -2);

        $sql .= "($listList) values ($valueList);";

        // var_dump($sql);
        self::query($sql);
    }
}