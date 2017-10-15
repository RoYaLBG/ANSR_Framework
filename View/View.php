<?php
namespace ANSR\View;

use ANSR\Config\Path\PathConfigInterface;
use ANSR\Core\Annotation\Strategy\RouteExecutionStrategy;
use ANSR\Core\Application;
use ANSR\Core\WebApplication;
use ANSR\Core\Http\Component\SessionInterface;
use ANSR\Core\Http\Response\ViewResponse;
use ANSR\Routing\RouterInterface;
use ANSR\Core\Annotation\Type\Component;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 *
 * @Component
 */
class View implements ViewInterface
{
    const VIEWS_FOLDER = '/views/';
    const VIEWS_EXTENSION = ".php";
    const SUFFIX_CONTROLLER = 'Controller';

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var PathConfigInterface
     */
    private $pathConfig;

    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(RouterInterface $router,
                                PathConfigInterface $pathConfig,
                                SessionInterface $session)
    {
        $this->router = $router;
        $this->pathConfig = $pathConfig;
        $this->session = $session;
    }

    public function render($model = null, $viewName = null): ViewResponse
    {
        if (is_string($model) && $viewName == null) {
            $viewName = $model;
        }

        if ($viewName != null) {
            if (strstr($viewName, ".")) {
                return new ViewResponse($viewName, $this, $model);
            }

            return new ViewResponse($viewName . self::VIEWS_EXTENSION, $this, $model);
        }

        $controller = $this->router->getControllerName();
        $appFolder = explode("\\", trim($controller, "\\"))[0];
        $folder = str_replace(self::SUFFIX_CONTROLLER, "", basename($controller));
        $name = strtolower($this->router->getActionName());
        $viewName = Application::APPLICATIONS_FOLDER
            . DIRECTORY_SEPARATOR
            . $appFolder
            . DIRECTORY_SEPARATOR
            . self::VIEWS_FOLDER
            . DIRECTORY_SEPARATOR
            . $folder
            . DIRECTORY_SEPARATOR
            . $name
            . self::VIEWS_EXTENSION;

        return new ViewResponse($viewName, $this, $model);
    }

    public function flushFlashMessages()
    {
        $this->session->flushFlashMessages();
    }

    public function url($namedRoute, ...$params): string
    {
        $uri = $this->router->getHostname();

        $cacheDir = $this->pathConfig->getCacheDir();
        $file = $cacheDir . DIRECTORY_SEPARATOR . RouteExecutionStrategy::CACHE_FILE;
        $routes = include($file);
        $info = [];

        foreach ($routes as $route) {
            if (array_key_exists($namedRoute, $route[RouteExecutionStrategy::KEY_NAME])) {
                $info = $route[RouteExecutionStrategy::KEY_NAME][$namedRoute];
                break;
            }
        }

        $template = $info[RouteExecutionStrategy::KEY_TEMPLATE];

        if (empty($params)) {
            return $uri . $template;
        }

        $tokens = explode('/', trim($template, '/'));
        $position = 0;

        if (is_array($params[0])) {
            $params = $params[0];
            foreach ($tokens as $token) {
                if (strpos($token, '(') !== 0 || strpos($token, ')') !== strlen($token)-1) {
                    $uri .= '/' . $token;
                    continue;
                }

                $currentPosition = 0;
                foreach ($info[RouteExecutionStrategy::KEY_ARGUMENTS] as $arg) {
                    if ($currentPosition == $position) {
                        $uri .= '/' . $params[$arg];
                        break;
                    }
                    $currentPosition++;
                }

                $position++;
            }

            return $uri;
        }

        foreach ($tokens as $token) {
            if (strpos($token, '(') !== 0 || strpos($token, ')') !== strlen($token) - 1) {
                $uri .= '/' . $token;
                continue;
            }

            $uri .= '/' . $params[$position++];
        }

        return $uri;
    }


    public function getFlash($key)
    {
        return $this->session->getFlashMessages($key);
    }
}

