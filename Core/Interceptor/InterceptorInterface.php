<?php

namespace ANSR\Core\Interceptor;


use ANSR\Core\Http\Component\RequestInterface;
use ANSR\Core\Http\Response\ResponseInterface;

interface InterceptorInterface
{
    public function preHandle(RequestInterface $request, ResponseInterface $response): ResponseInterface;
}