<?php

namespace Autoload;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
abstract class AbstractLoader {

    protected static $_extension = '.php';

    public static function registerAutoLoad() {
        spl_autoload_register(array(get_called_class(), 'autoload'));
    }

    protected static function autoload($class) {
        static::loadClass($class);
    }

    protected static function loadClass($class) {
        
    }

}
