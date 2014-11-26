<?php

namespace ANSR\Library\Request;

class Put {

    /**
     * @var array
     */
    private $_params;

    public function __construct(array $params) {
        $this->_params = $params;
    }

    public function getParams() {
        return $this->_params;
    }

    public function getParam($param) {
        return $this->_params[$param];
    }
}