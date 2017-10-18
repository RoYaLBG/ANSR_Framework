<?php

namespace ANSR\Core;


use ANSR\Core\Interceptor\InterceptorInterface;

interface InterceptorChainDelegate
{
    public function __invoke(): InterceptorInterface;
}