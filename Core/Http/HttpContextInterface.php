<?php

namespace ANSR\Core\Http;


use ANSR\Core\Http\Component\CookieInterface;
use ANSR\Core\Http\Component\RequestInterface;
use ANSR\Core\Http\Component\SessionInterface;

interface HttpContextInterface
{
    public function getSession(): SessionInterface;

    public function getCookie(): CookieInterface;

    public function getRequest(): RequestInterface;
}