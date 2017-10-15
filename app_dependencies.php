<?php
/** @var \ANSR\Autoload\AutoloadRegistrarInterface $autoloader */
/** @var \ANSR\Core\Container\ContainerInterface $container */
$container->addBean(
    \ANSR\Autoload\AutoloadRegistrarInterface::class,
    $autoloader
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
    \ANSR\Core\Container\ContainerInterface::class,
    $container
);