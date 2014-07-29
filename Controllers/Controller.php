<?php

namespace ANSR\Controllers;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
abstract class Controller {

    private $_app;
    private $_view;
    private $_request;
    
    public function __construct(\ANSR\App $app, \ANSR\View $view, \ANSR\Library\Request\Request $request) {
        $this->_app = $app;
        $this->_view = $view;
        $this->_request = $request;
        $this->init();
    }

    /**
     * Includes the apropriate view
     * @return void
     */
    public function render() {
        $this->getView()->initTemplate();
    }

    protected function init() { }

    /**
     * @return \ANSR\App
     */
    protected function getApp() {
        return $this->_app;
    }

    /**
     * @return \ANSR\View
     */
    protected function getView() {
        return $this->_view;
    }
    
    /**
     * @return \ANSR\Library\Request\Request
     */
    protected function getRequest() {
        return $this->_request;
    }

}
