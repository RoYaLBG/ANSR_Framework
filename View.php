<?php

namespace ANSR;

/**
 * @author Ivan Tonkov <ivanynkv@gmail.com>
 */
class View {

    private $_frontController;

    const VIEW_FOLDER = 'Views';
    const VIEW_DEFAULT = 'index';
    const VIEW_PARTIALS = 'partials';

    public function setFrontController(\ANSR\Dispatcher\FrontController $fronController) {
        $this->_frontController = $fronController;
    }

    /**
     * @return \ANSR\Dispatcher\FrontController
     */
    public function getFrontController() {
        return $this->_frontController;
    }

    /**
     * @return string (Template's path and filename)
     */
    public function getTemplate() {
        $action = !empty($this->getFrontController()->getRouter()->getAction()) ? $this->getFrontController()->getRouter()->getAction() : self::VIEW_DEFAULT;
        return self::VIEW_FOLDER
                . DIRECTORY_SEPARATOR
                . strtolower($this->getFrontController()->getRouter()->getController())
                . DIRECTORY_SEPARATOR
                . strtolower($action)
                . '.php';
    }

    /**
     * Includes template
     * @return void
     */
    public function initTemplate() {
        require_once $this->getTemplate();
    }

    public function partial($name) {
        include self::VIEW_FOLDER
                . DIRECTORY_SEPARATOR
                . self::VIEW_PARTIALS
                . DIRECTORY_SEPARATOR
                . $name;
    }

    public function __set($name, $value) {
        $this->$name = $value;
    }

    public function __get($name) {
        return $this->$name;
    }

}