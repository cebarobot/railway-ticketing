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

    public static function fetchRow($res, $row = null, $result_type = PGSQL_NUM) {
        return pg_fetch_row($res, $row, $result_type);
    }
    
	public static function selectFirst($querySQL, $opt = PGSQL_ASSOC) {
        $res = pg_query(self::$pgConnection, $querySQL);
        if (pg_num_rows($res) > 0) {
            return pg_fetch_array($res, 0, $opt);
        }
		return false;
    }

    public static function selectAll($querySQL) {
        $res = pg_query(self::$pgConnection, $querySQL);
        $arr = array();
        while($row = pg_fetch_assoc($res)) {
            $arr []= $row;
        }
        return $arr;
    }

    public static function updateOne($table, $data, $cond, $debug = false) {
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

        if ($debug) {
            var_dump($sql);
            return;
        }
        self::query($sql);
    }

    public static function insertOne($table, $data, $debug = false) {
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

        if ($debug) {
            var_dump($sql);
            return;
        }
        self::query($sql);
    }

    public static function insertOneGetId($table, $data, $idName, $debug = false) {
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

        $sql .= "($listList) values ($valueList) ";
        $sql .= "return $idName";

        if ($debug) {
            var_dump($sql);
            return;
        }
        $res = self::query($sql);
        return pg_fetch_row($res)[0];
    }
}