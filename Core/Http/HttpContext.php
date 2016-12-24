<?php
namespace ANSR\Core\Http;


use ANSR\Core\Http\Component\CookieInterface;
use ANSR\Core\Http\Component\RequestInterface;
use ANSR\Core\Http\Component\SessionInterface;

class HttpContext implements HttpContextInterface
{
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var CookieInterface
     */
    private $cookie;

    /**
     * @var RequestInterface
     */
    private $request;

    public function __construct(SessionInterface $session,
                                CookieInterface $cookie,
                                RequestInterface $request)
    {
        $this->session = $session;
        $this->cookie = $cookie;
        $this->request = $request;
    }

    /**
     * @return SessionInterface
     */
    public function getSession(): SessionInterface
    {
        return $this->session;
    }

    /**
     * @return CookieInterface
     */
    public function getCookie(): CookieInterface
    {
        return $this->cookie;
    }

    /**
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }
}