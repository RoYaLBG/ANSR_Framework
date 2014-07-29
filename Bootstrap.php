<?php

namespace ANSR;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class Bootstrap {

    public function __construct(App $app, View $view, $router) {
        $front = new \ANSR\Dispatcher\FrontController($app, $view);
        $front->setRouter($router);
        $front->dispatch();
    }

}