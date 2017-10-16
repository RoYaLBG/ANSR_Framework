<?php

namespace DefaultApp;


use ANSR\Core\FrameworkConsumer;
use DefaultApp\Service\UserService;
use DefaultApp\Service\UserServiceInterface;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class DefaultApp extends FrameworkConsumer
{
    public function preLoadHook()
    {
        parent::preLoadHook();

//        $this->container->registerDependency(
//            UserServiceInterface::class,
//            UserService::class
//        );
    }

}