<?php

namespace ANSR\Driver;


use ANSR\Core\Annotation\Type\Component;
use ANSR\Core\Annotation\Type\Value;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 *
 * @Component("10")
 */
class PDODatabase implements DatabaseInterface
{
    private $pdo;

    /**
     * @Value("db.host", param="host")
     * @Value("db.user", param="user")
     * @Value("db.pass", param="pass")
     * @Value("db.name", param="name")
     */
    public function __construct($host, $user, $pass, $name)
    {
        $dsn = "mysql:host=" . $host . ";dbname=" . $name;
        $this->pdo = new \PDO($dsn, $user, $pass);
    }

    public function prepare($query): DatabaseStatementInterface
    {
        $statement = $this->pdo->prepare($query);

        return new PDODatabaseStatement($statement);
    }

    public function lastId($name = null)
    {
        return $this->pdo->lastInsertId($name);
    }
}

