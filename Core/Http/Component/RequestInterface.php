<?php
namespace ANSR\Core\Http\Component;

interface RequestInterface
{
    public function getParameter(string $key): string;

    public function getHttpMethod(): string;

    public function getUri(): string;

    public function getScriptName(): string;

    public function getHost(): string;
}