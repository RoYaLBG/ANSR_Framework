<?php

namespace ANSR\Library\Request;

class RouteMap {

    /**
     * @var int
     */
    private $_patternIndex;

    /**
     * @var string
     */
    private $_requestKey;

    /**
     * @var \ANSR\Routing\Route
     */
    private $_route;

    /**
     * @param int $patternIndex
     * @param string $requestKey
     */
    public function __construct($patternIndex, $requestKey) {
        $this->_patternIndex = $patternIndex;
        $this->_requestKey = $requestKey;
    }

    /**
     * @return int
     */
    public function getPatternIndex() {
        return $this->_patternIndex;
    }

    /**
     * @return string
     */
    public function getRequestKey() {
        return $this->_requestKey;
    }

    /**
     * @return \ANSR\Routing\Route
     */
    public function getRoute() {
        return $this->_route;
    }

    /**
     * @param \ANSR\Routing\Route $route
     * @return void
     */
    public function setRoute(\ANSR\Routing\Route $route) {
        $this->_route = $route;
    }
}