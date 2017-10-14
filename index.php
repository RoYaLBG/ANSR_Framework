<?php
require_once 'autoloader.php';

$uri = $_SERVER['REQUEST_URI'];
$self = explode("/", $_SERVER['PHP_SELF']);
array_pop($self);
$replace = implode("/", $self);
$host = '//' . $_SERVER['HTTP_HOST'] . $replace;
$uri = str_replace($replace, "", $uri);
$container = new \ANSR\Core\Container\DefaultContainer();

require_once 'dependencies.php';

/** @var \ANSR\Core\Application $app */
$app = $container->resolve(\ANSR\Core\Application::class);
$app->registerApplication('DefaultApp');
$app->start();



