<?php

namespace ANSR\Adapters;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class MySQLi_Procedural extends Database {

    protected function connect() {
        $this->_conn = mysqli_connect($this->_host, $this->_user, $this->_pass, $this->_db)
                or die(mysqli_error($this->_conn));
    }

    public function query($query) {
        return mysqli_query($this->_conn, $query);
    }

    public function fetch($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function fetchArray($result) {
        while ($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function fetchObject($result) {
        while ($row = mysqli_fetch_object($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function row($result) {
        return mysqli_fetch_row($result);
    }

    public function result($result, $row = null) {
        if ($row == null) {
            $row = 0;
        } else {
            $row = $row;
        }
        mysqli_data_seek($result, $row);
        $res = $this->row($result);
        return $res[$row];
    }

    public function free($result) {
        return mysqli_free_result($result);
    }

    public function numRows($result) {
        return mysqli_num_rows($result);
    }

    public function affectedRows() {
        return mysqli_affected_rows($this->_conn);
    }

    public function escape($string) {
        return mysqli_real_escape_string($this->_conn, $string);
    }

    public function error() {
        return mysqli_error($this->_conn);
    }

    public function lastId() {
        return mysqli_insert_id($this->_conn);
    }

}