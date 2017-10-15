<?php
use ANSR\Core\Container\ContainerInterface;

require_once 'autoloader.php';

$uri = $_SERVER['REQUEST_URI'];
$self = explode("/", $_SERVER['PHP_SELF']);
array_pop($self);
$replace = implode("/", $self);
$host = '//' . $_SERVER['HTTP_HOST'] . $replace;
$uri = str_replace($replace, "", $uri);
\ANSR\Config\Variables::$args[\ANSR\GlobalConstants::KEY_HTTP_HOST] = $host;
\ANSR\Config\Variables::$args[\ANSR\GlobalConstants::KEY_HTTP_URI] = $uri;


$container = new \ANSR\Core\Container\DefaultContainer();
$kernel = new \ANSR\Core\Kernel($container);
$kernel->onApplicationLoad(function (ContainerInterface $container) use ($autoloader) {
    include 'app_dependencies.php';
});


$kernel->overrideAnnotationConfiguration(function (ContainerInterface $container) {
    /**
     * For the sake of the example,
     * @see \ANSR\Driver\MockDatabase is decorated by @Component
     * with higher priority than @see \ANSR\Driver\PDODatabase,
     * but we override it programmatically
     */
    $container->registerDependency(
        \ANSR\Driver\DatabaseInterface::class,
        \ANSR\Driver\PDODatabase::class
    );
});


$kernel->boot(function (\ANSR\Core\Application $app) {
    $app->registerApplication('DefaultApp');
});



