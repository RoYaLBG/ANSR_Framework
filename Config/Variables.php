<?php
namespace ANSR\Config;


use ANSR\GlobalConstants;

class Variables
{
    public static $args = null;
}
Variables::$args = [
    GlobalConstants::KEY_CACHE_DIR => 'cache',
    GlobalConstants::KEY_DB_HOST => DbConfig::DB_HOST,
    GlobalConstants::KEY_DB_NAME => DbConfig::DB_NAME,
    GlobalConstants::KEY_DB_USER => DbConfig::DB_USER,
    GlobalConstants::KEY_DB_PASS => DbConfig::DB_PASS,
    GlobalConstants::KEY_HTTP_REQUEST => $_REQUEST,
    GlobalConstants::KEY_HTTP_CONTEXT => $_SERVER,
];