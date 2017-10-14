<?php
require_once 'Autoload/AutoloadRegistrarInterface.php';
require_once 'Autoload/DefaultAutoloadRegistrar.php';
require_once 'Core/Application.php';

$autoloader = new \ANSR\Autoload\DefaultAutoloadRegistrar();
$autoloader->register(function ($class) {
    if (!strstr($class, \ANSR\Core\Application::VENDOR)) {
        return;
    }

    $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);
    $class = str_replace(\ANSR\Core\Application::VENDOR . DIRECTORY_SEPARATOR, "", $class);
    require_once $class . '.php';
});
