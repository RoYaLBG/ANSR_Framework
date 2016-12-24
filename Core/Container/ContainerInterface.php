<?php
/**
 * Created by IntelliJ IDEA.
 * User: RoYaL
 * Date: 12/22/2016
 * Time: 7:21 PM
 */

namespace ANSR\Core\Container;


interface ContainerInterface
{
    public function registerDependency(string $abstraction,
                                       string $implementation);

    public function addBean(string $abstraction, $object);

    public function resolve($name);

    public function getDependency($abstraction);

    public function exists($abstraction): bool;
}