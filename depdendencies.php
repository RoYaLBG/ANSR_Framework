<?php
/** @var \ANSR\Autoload\AutoloadRegistrarInterface $autoloader */
/** @var \ANSR\Core\Container\ContainerInterface $container */
$container->addBean(
    \ANSR\Autoload\AutoloadRegistrarInterface::class,
    $autoloader
);

$container->addBean(
    \ANSR\Driver\DatabaseInterface::class,
    new \ANSR\Driver\PDODatabase(
        \ANSR\Config\DbConfig::DB_HOST,
        \ANSR\Config\DbConfig::DB_USER,
        \ANSR\Config\DbConfig::DB_PASS,
        \ANSR\Config\DbConfig::DB_NAME
    )
);

$container->addBean(
    \ANSR\Core\Http\Component\SessionInterface::class,
    new \ANSR\Core\Http\Component\Session($_SESSION)
);

$container->registerDependency(
    \ANSR\Core\Service\Encryption\EncryptionServiceInterface::class,
    \ANSR\Core\Service\Encryption\BCryptEncryptionService::class
);

$container->registerDependency(
    \ANSR\Core\Service\Authentication\AuthenticationServiceInterface::class,
    \ANSR\Core\Service\Authentication\AuthenticationService::class
);

$container->registerDependency(
    \ANSR\Core\Service\User\UserServiceInterface::class,
    \ANSR\Core\Service\User\UserService::class
);

$container->registerDependency(
    \ANSR\View\ViewInterface::class,
    \ANSR\View\View::class
);

$container->addBean(
    \ANSR\Config\Path\PathConfigInterface::class,
    new \ANSR\Config\Path\PathConfig("cache")
);

$container->registerDependency(
    \ANSR\Config\Cache\CacheConfigInterface::class,
    \ANSR\Config\Cache\DefaultCacheConfig::class
);

$container->registerDependency(
    \ANSR\Core\Annotation\Parser\AnnotationParserInterface::class,
    \ANSR\Core\Annotation\Parser\AnnotationParser::class
);

$container->registerDependency(
    \ANSR\Core\Annotation\Processor\AnnotationProcessorInterface::class,
    \ANSR\Core\Annotation\Processor\DefaultAnnotationProcessor::class
);


$container->registerDependency(
    \ANSR\Core\Annotation\Strategy\AnnotationExecutionStrategyFactoryInterface::class,
    \ANSR\Core\Annotation\Strategy\AnnotationExecutionStrategyFactory::class
);

$container->registerDependency(
    \ANSR\Routing\RouterInterface::class,
    \ANSR\Routing\DefaultRouter::class
);

$container->addBean(
    \ANSR\Core\Http\Component\RequestInterface::class,
    new \ANSR\Core\Http\Component\Request($_REQUEST, $_SERVER, $uri, $host)
);

$container->addBean(
    \ANSR\Core\Container\ContainerInterface::class,
    $container
);