<?php

namespace ANSR\Library\Request;

/**
 * Class RouteMap
 *
 * A route map that consists of which placeholder in the route pattern
 * should be pushed in the request object.
 *
 * E.g. in pattern /user/[0-9]+ (resulting in http://yourApp.com/user/3)
 * a patternIndex 1 (referring to [0-9]+) and a requestKey "userId"
 * will result into hash "user_id" => 3. So calling from the controller
 * $this->getRequest()->getParam('user_id'); will return "3";
 *
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
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