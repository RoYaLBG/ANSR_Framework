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
     * An application can optionally have custom routes.
     * These routes consist of URI pattern, which controller to be called and which method to be invoked
     * as well as a request method in which they will be invoked
     *
     * This method checks whether a route pattern matches an URI and whether the REQUEST METHOD
     * is equal to the one defined. It might be a "standard" request which combines several
     * methods at once. E.g. POST or GET.
     *
     * @return Route|false
     */
    protected function getCustomRoute() {
        foreach (self::getRoutes() as $route) {
            $pattern = '/' . str_replace("/", "\\/", $route->getPattern()) . '/';
            $against = str_replace(basename(ROOT) . "/", "", $_SERVER['REQUEST_URI']);

            $isPatternValid = preg_match($pattern, $against);
            $isRequestValid = $route->getRequestMethod() == $_SERVER['REQUEST_METHOD'];
            $isMixedRequest = $route->getRequestMethod() == \ANSR\Library\Request\Request::TYPE_STANDARD;
            $isStandardRequest = in_array($_SERVER['REQUEST_METHOD'], explode('|',  \ANSR\Library\Request\Request::TYPE_STANDARD));

            if ($isPatternValid && ($isRequestValid || ($isMixedRequest && $isStandardRequest))) {
                return $route;
            }
        }
        return false;
    }
}