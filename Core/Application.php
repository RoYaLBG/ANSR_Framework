<?php

namespace ANSR\Core;


use ANSR\Autoload\AutoloadRegistrarInterface;
use ANSR\Config\Path\PathConfigInterface;
use ANSR\Core\Annotation\Processor\AnnotationProcessorInterface;
use ANSR\Core\Container\ContainerInterface;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class Application
{
    const VENDOR = 'ANSR';
    const APPLICATIONS_FOLDER = 'src';

    /**
     * @var AnnotationProcessorInterface
     */
    private $annotationProcessor;

    /**
     * @var PathConfigInterface
     */
    private $pathConfig;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var AutoloadRegistrarInterface
     */
    private $autoloadRegistrar;

    private $applications;

    public function __construct(AnnotationProcessorInterface $annotationProcessor,
                                PathConfigInterface $pathConfig,
                                ContainerInterface $container,
                                AutoloadRegistrarInterface $autoloadRegistrar)
    {
        $this->annotationProcessor = $annotationProcessor;
        $this->pathConfig = $pathConfig;
        $this->container = $container;
        $this->autoloadRegistrar = $autoloadRegistrar;
        $this->applications = [];
    }

    /**
     * @param WebApplicationProducerInterface|callable $webApplicationProducer
     */
    public function start($webApplicationProducer)
    {
        $this->annotationProcessor->process(
            array_merge(array_map(
                function ($app) {
                    return self::APPLICATIONS_FOLDER . DIRECTORY_SEPARATOR . $app;
                },
                $this->applications
            ), ['.'])
        );

        $this->container->initialLoad(
            $this->pathConfig->getCacheDir()
        );

        $webApplicationProducer()->start();
    }

    public function registerApplication($applicationName)
    {
        $this->applications[] = $applicationName;

        $this->autoloadRegistrar->register(function ($class) use ($applicationName) {
            if (!strstr($class, $applicationName)) {
                return;
            }

            $class = str_replace("\\", "/", $class);
            $class = self::APPLICATIONS_FOLDER
                . DIRECTORY_SEPARATOR
                . $class;

            if (is_readable($class . '.php')) {
                require_once $class . '.php';
            }
        });

        $consumerClass = $applicationName . '\\' . $applicationName;

        if (class_exists($consumerClass)) {
            /** @var FrameworkConsumer $consumer */
            $consumer = new $consumerClass($this->container);

            $consumer->preLoadHook();
        }
    }
}