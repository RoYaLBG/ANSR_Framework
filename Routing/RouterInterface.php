<?php

namespace ANSR\Routing;


use ANSR\Core\Http\Response\ResponseInterface;

interface RouterInterface
{
    public function getControllerName(): string;

    public function getActionName(): string;

    public function getParams(): array;

    public function getHostname(): string;

    public function dispatch(): ResponseInterface;
}