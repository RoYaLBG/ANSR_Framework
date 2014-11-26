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
     * @var string
     */
    private $_requestMethod;

    /**
     * @var \ANSR\Library\Request\RouteMap[]
     */
    private $_requestMap = [];

    public function __construct($pattern, $controller, $action, $requestMethod = \ANSR\Library\Request\Request::TYPE_STANDARD) {
        $this->_pattern = $pattern;
        $this->_controller = $controller;
        $this->_action = $action;

        $requestMethods = array_filter(array_flip((new \ReflectionClass('\ANSR\Library\Request\Request'))->getConstants()), function($const) {
           return strpos($const, 'TYPE') === 0;
        });

        if(!in_array($requestMethod, array_keys($requestMethods))) {
            throw new \Exception('Invalid request method');
        }
        $this->_requestMethod = $requestMethod;
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

    /**
     * @return string
     */
    public function getRequestMethod() {
        return $this->_requestMethod;
    }
}