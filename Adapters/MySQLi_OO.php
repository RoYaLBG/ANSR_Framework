<?php

namespace ANSR\Adapters;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class MySQLi_OO extends Database {

    protected $_result;
    protected $_content = array();

    public function connect() {
        $this->_conn = new \mysqli($this->_host, $this->_user, $this->_pass, $this->_db);
    }

    public function query($query) {
        return $this->_conn->query($query);
    }

    public function prepare($query) {
        $this->_result = $this->_conn->prepare($query);
        return $this;
    }

    public function commit() {
        return $this->_conn->commit();
    }

    public function bindParam(array $params) {
        $ref = new \ReflectionClass($this->_result);
        $method = $ref->getMethod("bind_param");
        $method->invokeArgs($this->_result, $params);
    }

    public function execute() {
        $this->_result->execute();
        return $this;
    }

    public function setFetch($table) {
        $result = $this->_result->get_result();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        $this->_content[$table] = $rows;
        return $this;
    }

    public function fetchAssoc($result) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function getContent($table) {
        return $this->_content[$table];
    }

}

