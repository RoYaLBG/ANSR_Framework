<?php

namespace ANSR\Autoload;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class DefaultAutoloadRegistrar implements AutoloadRegistrarInterface
{

    public function register(callable $callback)
    {
        spl_autoload_register($callback);
    }
}