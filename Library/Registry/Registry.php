<?php

namespace ANSR\Library\Registry;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
final class Registry {

    private static $_repository = array();

    private function __construct() { }

    public static function get($key) {
        if (array_key_exists($key, self::$_repository)) {
            return self::$_repository[$key];
        }
        throw new \ANSR\Library\Exception\RegistryException('Key does not exist');
    }

    public static function set($key, $value) {
        if (!array_key_exists($key, self::$_repository)) {
            self::$_repository[$key] = $value;
            return true;
        }
        throw new \ANSR\Library\Exception\RegistryException('Key already exist. To change it, flush it first');
    }

    public static function flush($key) {
        if (array_key_exists($key, self::$_repository)) {
            unset(self::$_repository[$key]);
            return true;
        }
        throw new \ANSR\Library\Exception\RegistryException('Key does not exist');
    }

}
