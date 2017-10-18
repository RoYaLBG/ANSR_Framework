<?php

namespace ANSR\Core;


use ANSR\Routing\RouterInterface;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class WebApplication
{
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
        $this->applications = [];
    }

    public function start()
    {
        $response = $this->router->dispatch();

        $response->send();
    }
}