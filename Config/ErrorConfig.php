<?php

namespace ANSR\Config;

final class ErrorConfig {

    private function __contrusct() { }

    public static function setDevelopmentConfig() {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
    }

    public static function setProductionConfig() {
        ini_set('display_errors', 0);
    }

}

