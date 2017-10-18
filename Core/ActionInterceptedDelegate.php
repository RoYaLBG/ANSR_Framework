<?php

namespace ANSR\Core;


use ANSR\Core\Http\Response\ResponseInterface;

interface ActionInterceptedDelegate
{
    public function __invoke(): ResponseInterface;
}