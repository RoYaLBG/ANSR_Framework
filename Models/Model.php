<?php

namespace ANSR\Models;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
abstract class Model {

    private $_app;
    private $_db;

    public function __construct(\ANSR\App $app, \ANSR\Adapters\Database $db) {
        $this->_app = $app;
        $this->_db = $db;
    }

    /**
     * @return \ANSR\App
     */
    protected function getApp() {
        return $this->_app;
    }

    /**
     * @return \ANSR\Adapters\Database
     */
    protected function getDb() {
        return $this->_db;
    }

}