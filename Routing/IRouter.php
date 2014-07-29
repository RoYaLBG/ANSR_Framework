<?php

namespace ANSR\Routing;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
interface IRouter {

    /**
     * @return string (Controller's name)
     */
    public function getController();

    /**
     * @return string (Action's name)
     */
    public function getAction();
}
