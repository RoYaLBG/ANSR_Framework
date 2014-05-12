<?php
namespace ANSR\Controllers;
/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
abstract class Controller {
	
	private $_app;
	private $_view;
	
	public function __construct(\ANSR\App $app, \ANSR\View $view) {
		$this->_app = $app;
		$this->_view = $view;
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
}
