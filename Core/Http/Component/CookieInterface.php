<?php
namespace ANSR\Core\Http\Component;

interface CookieInterface
{
    public function getAttribute(string $key): string;

    public function setAttribute(string $key, string $value);
}