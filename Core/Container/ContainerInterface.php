<?php

namespace ANSR\Core\Container;


interface ContainerInterface
{
    public function registerDependency(string $abstraction,
                                       string $implementation);

    public function addBean(string $abstraction, $object);

    public function resolve($name);

    public function getDependency($abstraction);

    public function exists($abstraction): bool;

    public function initialLoad(string $path);
}