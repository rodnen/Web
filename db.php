<?php
class DB
{
    private $options = [];
    private $con = null;
    function __construct($options) {
        $this->connect($options);
    }

    function connect($options) {
        $this->close();
        if (!isset($options['host'])) { $options['host'] = 'localhost';}
        if (!isset($options['user'])) { $options['user'] = null;}
        if (!isset($options['password'])) { $options['password'] = null;}
        $this->con = mysqli_connect($options['host'],
            $options['user'], $options['password']);
        if (!mysqli_select_db($this->con, $options['db'])) {
            $this->close();
        }
        if ($this->con) {
            $this->options = $options;
        }
    }

    function IsConnect() {
        return $this->con != null;
    }

    function Error() {
        if (!$this->con) return 'Помилка підключення до Бази Даних';
        return mysqli_error($this->con);
    }

    function close() {
        if ($this->con) mysqli_close($this->con);
        $this->con = null;
    }

    function __destruct() {
        $this->close();
    }

    function query($sql) {
        return mysqli_query($this->con, $sql);
    }
    
    function queryRow($sql) {
        $r = $this->queryOne($sql);
        return $r;
    }

    function queryOne($sql) {
        $r = $this->query($sql);
        if (!$r) return false;
        return mysqli_fetch_assoc($r);
    }

    function queryRows($sql) {
        $r = $this->query($sql);
        if (!$r) return false;
        $rows = [];
        while ($row = mysqli_fetch_assoc($r)) {
            $rows[] = $row;
        }
        return $rows;
    }
}


