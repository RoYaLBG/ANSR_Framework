<?php

namespace ANSR\Routing;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class DefaultRouter extends RouterAbstract implements IRouter {

    const REQUEST_URI_CONTROLLER = 2;
    const REQUEST_URI_ACTION = 3;

    public function getController() {
        if (!$this->getCustomRoute()) {
            return ucfirst(explode('/', $_SERVER['REQUEST_URI'])[self::REQUEST_URI_CONTROLLER]);
        }
        return $this->getCustomRoute()->getController();
    }

    public function getAction() {
        if (!$this->getCustomRoute()) {
            return explode('/', $_SERVER['REQUEST_URI'])[self::REQUEST_URI_ACTION];
        }
        return $this->getCustomRoute()->getAction();
    }

    public function registerRequest()
    {
        $request = explode('/', $_SERVER['REQUEST_URI']);
        $params = array();
        foreach ($request as $key => $param) {
            if ($key > self::REQUEST_URI_ACTION) {
                if (isset($request[$key], $request[$key + 1])) {
                    $params[$request[$key]] = $request[$key + 1];
                    unset($request[$key + 1]);
                }
            }
        }
        \ANSR\Library\Registry\Registry::set('request', $params);
    }

}