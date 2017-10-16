<?php

namespace ANSR\Driver;


use ANSR\Core\Annotation\Type\Component;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 *
 * @Component("200")
 */
class MockDatabase implements DatabaseInterface
{
    public function prepare($query): DatabaseStatementInterface
    {
        return new class implements DatabaseStatementInterface
        {

            public function fetchAll()
            {
                return [];
            }

            public function fetchRow()
            {
                return "";
            }

            public function fetchObject($className)
            {
                return new \stdClass();
            }

            public function execute(array $args = []): bool
            {
                return true;
            }
        };
    }

    public function lastId($name = null)
    {
        return -1;
    }
}