<?php

namespace ANSR\Autoload;

interface AutoloadRegistrarInterface
{
    public function register(callable $callback);
}