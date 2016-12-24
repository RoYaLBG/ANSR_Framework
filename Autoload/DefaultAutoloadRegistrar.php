<?php

namespace ANSR\Autoload;


class DefaultAutoloadRegistrar implements AutoloadRegistrarInterface
{

    public function register(callable $callback)
    {
        spl_autoload_register($callback);
    }
}