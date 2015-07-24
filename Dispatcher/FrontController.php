<?php

namespace ANSR\Dispatcher;
use ANSR\Controllers\Controller;

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

    const ANNOTATION_MODEL_VALIDATION = 'ModelValidation';

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
        if (\ANSR\Library\Registry\Registry::get('WEB_SERVICE') === true) {
            die(json_encode($this->mapMethodArguments($method)));
        } else {
            $this->mapMethodArguments($method);
        }
    }

    /**
     * @param string $method
     * @return \ReflectionParameter[]
     */
    private function getMethodArguments($method)
    {
        $refM = new \ReflectionMethod($this->getController(), $method);

        return $refM->getParameters();
    }

    private function isModelValidated($method)
    {
        $refM = new \ReflectionMethod($this->getController(), $method);
        $doc = $refM->getDocComment();
        preg_match_all('#@(.*?)\n#s', $doc, $annotations);

        $metadata = array_map('trim', $annotations[1]);

        return in_array(self::ANNOTATION_MODEL_VALIDATION, $metadata);
    }

    private function mapMethodArguments($method)
    {
        if (!$this->isModelValidated($method)) {
            return $this->getController()->$method();
        }

        if ($this->_request->getPost()->getParams()) {
            $params = $this->_request->getPost()->getParams();
        } else if ($this->_request->getPut()->getParams()) {
            $params = $this->_request->getPut()->getParams();
        } else {
            return $this->getController()->$method();
        }

        $arguments = $this->getMethodArguments($method);
        $model = $arguments[0];

        try {
            $refC = $model->getClass();
            $className = $refC->getName();
            $class = new $className();

            foreach ($params as $name => $value) {
                $setter = 'set' . $name;

                if (!method_exists($class, $setter)) {
                    throw new \Exception('Invalid model state');
                }

                $class->$setter($value);
            }

            return $this->getController()->$method($class);
        } catch (\Exception $e) {
            throw new \Exception('Invalid model state');
        }
    }

    
    private function initRequest() {
        $this->getRouter()->registerRequest();
        parse_str(file_get_contents("php://input"), $_PUT);

        $post = new \ANSR\Library\Request\Post($_POST);
        $put = new \ANSR\Library\Request\Put($_PUT);
        $this->_request = new \ANSR\Library\Request\Request(\ANSR\Library\Registry\Registry::get('request'), $post, $put);
    }

}

