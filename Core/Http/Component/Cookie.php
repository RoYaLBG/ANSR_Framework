<?php
namespace ANSR\Core\Http\Component;

class Cookie implements CookieInterface
{
    private $cookies = [];
    private $cookieHandler;

    public function __construct(array &$cookies, callable $cookieHandler)
    {
        $this->cookies = $cookies;
        $this->cookieHandler = $cookieHandler;
    }

    public function getAttribute(string $key): string
    {
        return $this->cookies[$key];
    }

    public function setAttribute(string $key, string $value)
    {
        $cookieHandler = $this->cookieHandler;
        $cookieHandler($key, $value);
        $this->cookies[$key] = $value;
    }
}