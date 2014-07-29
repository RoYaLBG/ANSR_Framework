<?php

namespace Autoload;

include 'AbstractLoader.php';

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
final class DefaultLoader extends AbstractLoader {

    protected static function loadClass($class) {
        $namespace = substr($class, 0, strrpos($class, '\\'));
        $namespace = str_replace('\\', DIRECTORY_SEPARATOR, $class);
        $classPath = ROOT . str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . '.php';
        $classPath = str_replace('ANSR', '', $classPath);   
        if (is_readable($classPath)) {
            require_once $classPath;
        }
    }

}