<?php
namespace ANSR\Core;


use ANSR\Autoload\AutoloadRegistrarInterface;
use ANSR\Core\Annotation\Processor\AnnotationProcessorInterface;
use ANSR\Core\Container\ContainerInterface;
use ANSR\Routing\RouterInterface;
use ANSR\View\ViewInterface;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class Application
{
    const VENDOR = 'ANSR';
    const APPLICATIONS_FOLDER = 'src';

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var AutoloadRegistrarInterface
     */
    private $autoloadRegistrar;

    /**
     * @var AnnotationProcessorInterface
     */
    private $annotationProcessor;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var ViewInterface
     */
    private $view;

    private $applications;

    public function __construct(ContainerInterface $container,
                                AutoloadRegistrarInterface $autoloadRegistrar,
                                AnnotationProcessorInterface $annotationProcessor,
                                RouterInterface $router,
                                ViewInterface $view)
    {
        $this->container = $container;
        $this->autoloadRegistrar = $autoloadRegistrar;
        $this->annotationProcessor = $annotationProcessor;
        $this->router = $router;
        $this->view = $view;
        $this->applications = [];
    }

    public function start()
    {
        $this->annotationProcessor->process(
            array_map(
                function($app) {
                    return self::APPLICATIONS_FOLDER . DIRECTORY_SEPARATOR . $app;
                },
                $this->applications
            )
        );

        $response = $this->router->dispatch();

        $response->send();
    }

    public function registerApplication($applicationName)
    {
        $this->applications[] = $applicationName;

        $this->autoloadRegistrar->register(function($class) use($applicationName) {
           if (!strstr($class, $applicationName)) {
               return;
           }

            $class = str_replace("\\", "/", $class);
            $class = self::APPLICATIONS_FOLDER
                . DIRECTORY_SEPARATOR
                . $class;

            require_once $class . '.php';
        });

        $consumerClass = $applicationName . '\\' . $applicationName;

        if (class_exists($consumerClass)) {
            /** @var FrameworkConsumer $consumer */
            $consumer = new $consumerClass($this->container);

            $consumer->preLoadHook();
        }
    }

}