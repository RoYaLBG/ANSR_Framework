<?php

namespace ANSR;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */

/**
 * 	Add models here in order to have autocompletion in the controller
 *  @property \ANSR\Models\TestModel $TestModel
 * 
 */
final class App {

    /**
     * @var \ANSR\Adapters\Database
     */
    private $_db;
    private $_routers = array();
    private $_models = array();

    public function __construct(\ANSR\Adapters\Database $db) {
        $this->_db = $db;
        $this->addRouters();
    }

    private function addRouters() {
        $skipFiles = array('.', '..', 'IRouter.php');
        foreach (scandir(ROOT . DIRECTORY_SEPARATOR . 'Routing') as $router) {
            if (!in_array($router, $skipFiles)) {
                $router = str_replace('.php', '', $router);
                $class = 'ANSR\Routing\\' . $router;
                $this->_routers[$router] = new $class;
            }
        }
    }

    /**
     * @return \ANSR\Routing\IRouter
     */
    public function getRouters() {
        return $this->_routers;
    }

    public function __get($name) {
        $model = '\ANSR\Models\\' . $name;
        if (class_exists($model)) {
            $this->_models[$name] = new $model($this, $this->_db);
            return $this->_models[$name];
        }
    }

}
