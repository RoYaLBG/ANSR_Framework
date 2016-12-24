<?php

namespace ANSR\Core\Annotation\Strategy;


use ANSR\Config\Path\PathConfigInterface;
use ANSR\Core\Annotation\Type\Route;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class RouteExecutionStrategy extends ContainerAwareExecutionStrategy
{
    const CACHE_FILE = 'routes.php';

    const KEY_CONTROLLER = 'controller';
    const KEY_ACTION = 'action';
    const KEY_ARGUMENTS = 'args';
    const KEY_NAME = 'name';
    const KEY_TEMPLATE = 'template';

    /**
     * @var Route
     */
    protected $annotation;

    public function execute()
    {
        /** @var PathConfigInterface $config */
        $config = $this->container->resolve(PathConfigInterface::class);
        $cacheFile = $config->getCacheDir()
            . DIRECTORY_SEPARATOR
            . self::CACHE_FILE;

        $routes = [];
        if (file_exists($cacheFile)) {
            $routes = include($cacheFile);
            if (!is_array($routes)) {
                $routes = [];
            }
        }

        $requestMethod = $this->annotation->getMethod();
        $class = $this->annotation->getAnnotatedClass();
        $action = $this->annotation->getAnnotatedMethod();

        $routeTemplateRaw = $this->annotation->getValue();
        $routeTemplate = "";
        $args = [];
        $tokens = explode("/", $routeTemplateRaw);
        foreach ($tokens as $token) {
            if (strpos($token, '{') === 0 && strpos($token, '}') === strlen($token)-1) {
                $token = trim($token, '}');
                $token = trim($token, '{');
                $validationRules = explode(":", $token);
                if (count($validationRules) > 1) {
                    $routeTemplate .= '/(' . trim($validationRules[1]) . ')';
                } else {
                    $routeTemplate .= '/(.*?)';
                }
                $args[$validationRules[0]] = $validationRules[0];
            } else {
                $routeTemplate .= '/' . $token;
            }
        }
        $routeTemplate = substr($routeTemplate, 1, strlen($routeTemplate));
        $name = $this->annotation->getName();

        $routes[$requestMethod][self::KEY_TEMPLATE][$routeTemplate] = [
            self::KEY_CONTROLLER => $class->getName(),
            self::KEY_ACTION => $action->getName(),
            self::KEY_ARGUMENTS => $args,
            self::KEY_NAME => $name
        ];

        if ($name) {
            $routes[$requestMethod][self::KEY_NAME][$name] = [
                self::KEY_CONTROLLER => $class->getName(),
                self::KEY_ACTION => $action->getName(),
                self::KEY_ARGUMENTS => $args,
                self::KEY_TEMPLATE => $routeTemplate
            ];
        }

        $data = var_export($routes, true);

        file_put_contents($cacheFile, '<?php return ' . $data . ';');
    }
}