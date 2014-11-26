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
     * Includes the appropriate view
     * @return void
     */
    public function render() {
        if (\ANSR\Library\Registry\Registry::get('WEB_SERVICE') !== true) {
            $this->getView()->initTemplate();
        }
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

    protected function error(array $params = []) {
        return array_merge(['success' => 0], $params);
    }

    protected function success(array $params = []) {
        return array_merge(['success' => 1], $params);
    }

}
