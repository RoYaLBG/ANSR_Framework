<?php

namespace ANSR\Core;


use ANSR\Routing\RouterInterface;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class WebApplication
{
    const APPLICATIONS_FOLDER = 'src';
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