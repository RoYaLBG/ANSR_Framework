<?php
/**
 * Created by IntelliJ IDEA.
 * User: RoYaL
 * Date: 10/15/2017
 * Time: 7:18 PM
 */

namespace ANSR\Core;


use ANSR\Core\Container\ContainerInterface;

interface ContainerDelegate
{
    public function __invoke(ContainerInterface $container);
}