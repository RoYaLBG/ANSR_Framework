<?php
namespace ANSR\Routing;

abstract class RouterAbstract {

    /**
     * @var Route[]
     */
    protected static $_routes = [];

    /**
     * @param Route $route
     * @return \ANSR\Routing\RouterAbstract static bound
     */
    public static function addRoute(Route $route) {
        self::$_routes[] = $route;

        return new static;
    }

    /**
     * @return Route[]
     */
    public static function getRoutes() {
        return self::$_routes;
    }

    /**
     * @return Route|false
     */
    protected function getCustomRoute() {
        foreach (self::getRoutes() as $route) {
            $pattern = '/' . str_replace("/", "\\/", $route->getPattern()) . '/';
            $against = str_replace(basename(ROOT) . "/", "", $_SERVER['REQUEST_URI']);
            if (preg_match($pattern, $against)) {
                return $route;
            }
        }
        return false;
    }
}