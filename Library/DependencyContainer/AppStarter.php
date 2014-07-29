<?php

namespace ANSR\Library\DependencyContainer;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
final class AppStarter {

    private function __construct() {
        
    }

    /**
     * Starts the application
     * Builds all necessary injections for App, View and FrontController
     * @param string $dbType (Database type from Adapters/)
     * @param string $router (Router type from Routing/)
     * @param string $configLevel (ErrorConfig level from Config)
     */
    public static function createApp($dbType, $router, $configLevel) {
        $configLevel = 'set' . ucfirst($configLevel) . 'Config';
        \ANSR\Config\ErrorConfig::$configLevel();
        /* @var \ANSR\Adapters\Database $db */
        $db = '\ANSR\Adapters\\' . $dbType;
        $db = new $db(
            \ANSR\Config\DbConfig::HOST,
            \ANSR\Config\DbConfig::USER,
            \ANSR\Config\DbConfig::PASS,
            \ANSR\Config\DbConfig::DATABASE
        );

        /* @var \ANSR\App $app */
        $app = new \ANSR\App($db);
        /* @var \ANSR\View $view */
        $view = new \ANSR\View();
        new \ANSR\Bootstrap($app, $view, $router);
    }

}
