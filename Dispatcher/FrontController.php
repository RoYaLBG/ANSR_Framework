<?php

namespace ANSR\Dispatcher;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class FrontController {

    /**
     * @var \ANSR\App
     */
    private $_app;
    
    /**
     * @var \ANSR\Library\Request\Request
     */
    private $_request;

    /**
     * @var \ANSR\View
     */
    private $_view;
    private $_router;
    private $_controller;
    private $_method;

    public function __construct(\ANSR\App $app, \ANSR\View $view) {
        $this->_app = $app;
        $view->setFrontController($this);
        $this->_view = $view;
    }

    /**
     * Requires controller and calls specified method
     * @return void
     */
    public function dispatch() {
        try {
            $this->initRequest();
            $this->initController();
            $this->initAction();
            $this->_controller->render();
        } catch (\ANSR\Library\Exception\LoadException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    /**
     * @param string $router
     */
    public function setRouter($router) {
        $this->_router = $router;
    }

    /**
     * @return \ANSR\Routing\IRouter
     */
    public function getRouter() {
        return $this->_app->getRouters()[$this->_router];
    }

    /**
     * @return \ANSR\Controllers\Controller
     */
    public function getController() {
        return $this->_controller;
    }

    private function initController() {
        if (!empty($this->getRouter()->getController())) {
            $class = 'ANSR\Controllers\\' . $this->getRouter()->getController();
            if (!class_exists($class)) {
                throw new \ANSR\Library\Exception\LoadException('Controller not found');
            }
            $this->_controller = new $class($this->_app, $this->_view, $this->_request);
        }
    }

    private function initAction() {
        if (!empty($this->getRouter()->getAction())) {
            $this->_method = $this->getRouter()->getAction();
            $this->callMethod();
        }
    }

    private function callMethod() {
        if (!method_exists($this->getController(), $this->_method)) {
            throw new \ANSR\Library\Exception\LoadException('Undefined method ' . $this->_method);
        }
        $method = $this->_method;
        $this->getController()->$method();
    }
    
    private function initRequest() {
        $this->getRouter()->registerRequest();
        $post = new \ANSR\Library\Request\Post($_POST);
        $this->_request = new \ANSR\Library\Request\Request(\ANSR\Library\Registry\Registry::get('request'), $post);
    }

}

