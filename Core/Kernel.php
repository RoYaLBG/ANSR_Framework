<?php

namespace ANSR\Core;


use ANSR\Core\Container\ContainerInterface;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class Kernel
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var ContainerDelegate;
     */
    private $configOverrideDelegate;

    private $hasBoot;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->hasBoot = false;
        $this->configOverrideDelegate = function (ContainerInterface $c) {
        };
    }

    /**
     * @param ContainerDelegate|callable $loaderDelegate
     * @return $this
     */
    public function onApplicationLoad($loaderDelegate)
    {
        $loaderDelegate($this->container);

        return $this;
    }

    /**
     * @param ContainerDelegate|callable $overrideDelegate
     * @return $this
     */
    public function overrideAnnotationConfiguration($overrideDelegate)
    {
        $this->configOverrideDelegate = $overrideDelegate;

        return $this;
    }

    /**
     * @param ApplicationDelegate|callable $appStarterDelegate
     * @throws \Exception
     */
    public function boot($appStarterDelegate)
    {
        if ($this->hasBoot) {
            throw new \Exception("The kernel has already boot");
        }

        $container = $this->container;
        $overrideDelegate = $this->configOverrideDelegate;

        /** @var Application $app */
        $app = $container->resolve(Application::class);
        $appStarterDelegate($app);
        $app->start(function () use ($container, $overrideDelegate) {
            $overrideDelegate($container);
            return $container->resolve(WebApplication::class);
        });

        $this->hasBoot = true;
    }
}