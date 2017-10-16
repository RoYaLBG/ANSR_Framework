<?php

namespace ANSR\Core;


use ANSR\Core\Container\ContainerInterface;

interface ContainerDelegate
{
    public function __invoke(ContainerInterface $container);
}