<?php
ini_set('display_errors', 1);
#################################################
#                                               #
#				ANSR Framework                  #
#	@author Ivan Yonkov <ivanynkv@gmail.com>    #
#                                               #
#	A very basic MVC framework which has        #
#	default router for routing schema           #
#	/controller/action/. It has two basic       #
#	wrappers for database (mysqli) -> object    #
#	oriented one, and procedural one.           #
#                                               #
#	If one needs additional configs, wrappers   #
#	or libraries, can follow the namespace      #
#	schema and level of abstraction which can   #
#	be found in each abstract class.            #																											#
#                                               #
#	The framework uses PHP 5.5.                 #
#                                               #
#	Some features might not work on	            #
#	lower versions                              #
#                                               #
#################################################
define('ROOT', __DIR__ . DIRECTORY_SEPARATOR);
include 'Autoload/DefaultLoader.php';
Autoload\DefaultLoader::registerAutoload();

$__router = '\ANSR\Routing\DefaultRouter';
/** @var $__router \ANSR\Routing\IRouter|\ANSR\Routing\RouterAbstract */

$__router
    ::addRoute(new \ANSR\Routing\Route("/my/pattern/for/test/and/something/[0-9]+", "Test", "print_smth"))
    ->addRoute(new \ANSR\Routing\Route("/my/pattern/for/anothertest/and/something/[0-9]+", "Test", "another"));

\ANSR\Library\Registry\Registry::set('WEB_SERVICE', true);

\ANSR\Library\DependencyContainer\AppStarter::createApp('MySQLi_Procedural', 'DefaultRouter', 'development');