<?php
namespace ANSR\Routing;

class Route {

    private $_pattern;

    private $_controller;

    private $_action;

    public function __construct($pattern, $controller, $action) {
        $this->_pattern = $pattern;
        $this->_controller = $controller;
        $this->_action = $action;
    }

    public function getPattern() {
        return $this->_pattern;
    }

    public function getController() {
        return $this->_controller;
    }

    public function getAction() {
        return $this->_action;
    }
}