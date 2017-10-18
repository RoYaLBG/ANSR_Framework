<?php

namespace ANSR\Core\Interceptor;


interface InterceptorChainInterface
{
    /**
     * @return InterceptorInterface|null;
     */
    public function current();

    public function moveNext();
}