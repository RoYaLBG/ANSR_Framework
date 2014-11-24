<?php
namespace ANSR\Routing;

class Route {

    /**
     * @var string (regex pattern)
     */
    private $_pattern;

    /**
     * @var string
     */
    private $_controller;

    /**
     * @var string
     */
    private $_action;

    /**
     * @var \ANSR\Library\Request\RouteMap[]
     */
    private $_requestMap = [];

    public function __construct($pattern, $controller, $action) {
        $this->_pattern = $pattern;
        $this->_controller = $controller;
        $this->_action = $action;
    }

    /**
     * @return string
     */
    public function getPattern() {
        return $this->_pattern;
    }

    /**
     * @return string
     */
    public function getController() {
        return $this->_controller;
    }

    /**
     * @return string
     */
    public function getAction() {
        return $this->_action;
    }

    /**
     * @param \ANSR\Library\Request\RouteMap $routeMap
     * @return $this
     */
    public function addRequestMapping(\ANSR\Library\Request\RouteMap $routeMap) {
        $routeMap->setRoute($this);
        $this->_requestMap[] = $routeMap;

        return $this;
    }

    /**
     * @return \ANSR\Library\Request\RouteMap[]
     */
    public function getRequestMap() {
        return $this->_requestMap;
    }
}