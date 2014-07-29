<?php

namespace ANSR\Routing;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class DefaultRouter implements IRouter {

    const REQUEST_URI_CONTROLLER = 1;
    const REQUEST_URI_ACTION = 2;

    public function getController() {
        return ucfirst(explode('/', $_SERVER['REQUEST_URI'])[self::REQUEST_URI_CONTROLLER]);
    }

    public function getAction() {
        return explode('/', $_SERVER['REQUEST_URI'])[self::REQUEST_URI_ACTION];
    }

    public function pushActionParams() {
        $request = explode('/', $_SERVER['REQUEST_URI']);
        $params = array();
        foreach ($request as $key => $param) {
            if ($key > self::REQUEST_URI_ACTION) {
                $params[] = $param;
            }
        }
        \ANSR\Library\Registry\Registry::set('action_params', $params);
    }

}