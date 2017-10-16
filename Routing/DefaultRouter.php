<?php

namespace ANSR\Routing;


use ANSR\Config\Path\PathConfigInterface;
use ANSR\Core\Annotation\Strategy\AuthExecutionStrategy;
use ANSR\Core\Annotation\Strategy\RouteExecutionStrategy;
use ANSR\Core\WebApplication;
use ANSR\Core\Container\ContainerInterface;
use ANSR\Core\Http\Component\RequestInterface;
use ANSR\Core\Http\Response\RedirectResponse;
use ANSR\Core\Http\Response\ResponseInterface;
use ANSR\Core\IO\DirectoryTraverser;
use ANSR\Core\Service\Authentication\AuthenticationServiceInterface;
use ANSR\View\ViewInterface;
use ANSR\Core\Annotation\Type\Component;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 *
 * @Component
 */
class DefaultRouter implements RouterInterface
{
    const SUFFIX_CONTROLLER = 'Controller';
    const SUFFIX_ACTION = 'Action';
    const UNAThORIZED_REDIRECT_ROUTE = 'login';

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var PathConfigInterface
     */
    private $pathConfig;

    /**
     * @var AuthenticationServiceInterface
     */
    private $authenticationService;

    /**
     * @var ContainerInterface
     */
    private $container;

    private $routes;

    private $controllerName;

    private $actionName;

    private $arguments;

    public function __construct(RequestInterface $request,
                                PathConfigInterface $pathConfig,
                                AuthenticationServiceInterface $authenticationService,
                                ContainerInterface $container)
    {
        $this->request = $request;
        $this->pathConfig = $pathConfig;
        $this->authenticationService = $authenticationService;
        $this->container = $container;
    }

    public function getControllerName(): string
    {
        return $this->controllerName;
    }

    public function getActionName(): string
    {
        return $this->actionName;
    }

    public function getParams(): array
    {
        return $this->arguments;
    }

    public function getHostname(): string
    {
        return $this->request->getHost();
    }

    public function dispatch(): ResponseInterface
    {
        $this->loadRoutes();
        $info = $this->findRoute();

        if (!$info) {
            $info = $this->resolveDefaultRoute();
        }

        if (!$info) {
            throw new \Exception("No controller or action matches the given route");
        }

        $controllerName = $info[RouteExecutionStrategy::KEY_CONTROLLER];
        $actionName = $info[RouteExecutionStrategy::KEY_ACTION];

        $authInfo = include($this->pathConfig->getCacheDir() . DIRECTORY_SEPARATOR . AuthExecutionStrategy::CACHE_FILE);
        if (isset($authInfo[$controllerName]) && isset($authInfo[$controllerName][$actionName])) {
            $roles = $authInfo[$controllerName][$actionName];
            if (empty($roles) && !$this->authenticationService->isLogged()) {
                return new RedirectResponse($this->container->resolve(ViewInterface::class)->url(self::UNAThORIZED_REDIRECT_ROUTE));
            }

            $hasRole = false;
            foreach ($roles as $role) {
                if ($this->authenticationService->hasRole($role)) {
                    $hasRole = true;
                    break;
                }
            }

            if (!$hasRole) {
                return new RedirectResponse($this->container->resolve(ViewInterface::class)->url(self::UNAThORIZED_REDIRECT_ROUTE));
            }
        }

        $this->controllerName = $controllerName;
        $this->actionName = $actionName;

        $controller = $this->container->resolve($controllerName);

        $refMethod = new \ReflectionMethod($controller, $actionName);
        $refParams = $refMethod->getParameters();

        $count = count($this->arguments);

        $params = [];
        $primitiveIndex = 0;
        for ($i = 0; $i < count($refParams); $i++) {
            $argument = $refParams[$i];
            $argumentType = $argument->getClass();
            if (!$argumentType) {
                $params[$i] = $this->arguments[$primitiveIndex++];
                continue;
            }
            $argumentInterface = $argumentType->getName();
            if ($this->container->exists($argumentInterface)) {
                $argumentClass = $this->container->getDependency($argumentInterface);
                $params[$i] = $this->container->resolve($argumentClass);
            } else {
                $bindingModel = new $argumentInterface;
                $this->bindData($_POST, $bindingModel);
                $params[$i] = $bindingModel;
            }
        }

        $result = call_user_func_array(
            [
                $controller,
                $actionName
            ],
            $params
        );

        return $result;
    }

    private function loadRoutes()
    {
        $this->routes = include(
            $this->pathConfig->getCacheDir()
            . DIRECTORY_SEPARATOR
            . RouteExecutionStrategy::CACHE_FILE
        );
    }

    private function findRoute()
    {
        $uri = $this->request->getUri();
        $method = $this->request->getHttpMethod();
        $info = [];
        $templates = $this->routes[$method][RouteExecutionStrategy::KEY_TEMPLATE];
        if (array_key_exists($uri, $templates)) {
            $info = $templates[$uri];

            return $info;
        }

        foreach ($templates as $pattern => $templateInfo) {
            $pattern = "%^$pattern$%";
            if (preg_match_all($pattern, $uri, $matches)) {
                $info = $templateInfo;
                for ($i = 1; $i < count($matches); $i++) {
                    $this->arguments[] = $matches[$i][0];
                }
                break;
            }
        }

        return $info;
    }

    private function resolveDefaultRoute()
    {
        $uri = $this->request->getUri();
        $uri = trim($uri, '/');
        $tokens = explode("/", $uri);
        $controllerName = array_shift($tokens);
        $actionName = array_shift($tokens);
        $args = [];
        foreach ($tokens as $arg) {
            $args[$arg] = $arg;
        }
        $name = "";

        $appFolder = WebApplication::APPLICATIONS_FOLDER;

        foreach (scandir($appFolder) as $dir) {
            if ($dir == '.' || $dir == '..' || !is_dir($appFolder . DIRECTORY_SEPARATOR . $dir)) {
                continue;
            }

            foreach (DirectoryTraverser::findApplicationClasses($appFolder . DIRECTORY_SEPARATOR . $dir) as $className) {
                if (strpos($className, $appFolder) === 0) {
                    $className = str_replace($appFolder, "", $className);
                }

                $baseName = basename($className);
                $baseName = str_replace(self::SUFFIX_CONTROLLER, "", $baseName);

                if (strtolower($baseName) != strtolower($controllerName)) {
                    continue;
                }

                $refClass = new \ReflectionClass($className);
                foreach ($refClass->getMethods() as $method) {
                    $rawName = str_replace(self::SUFFIX_ACTION, "", $method->getName());
                    if (strtolower($rawName) == strtolower($actionName)) {
                        return [
                            RouteExecutionStrategy::KEY_CONTROLLER => $className,
                            RouteExecutionStrategy::KEY_ACTION => $method->getName(),
                            RouteExecutionStrategy::KEY_ARGUMENTS => $args,
                            RouteExecutionStrategy::KEY_NAME => $name
                        ];
                    }
                }
            }
        }

        return [];
    }

    private function bindData(array $data, $object)
    {
        $refClass = new \ReflectionClass($object);
        $fields = $refClass->getProperties();
        foreach ($fields as $field) {
            $field->setAccessible(true);
            if (array_key_exists($field->getName(), $data)) {
                $field->setValue($object, $data[$field->getName()]);
            }
        }
    }
}