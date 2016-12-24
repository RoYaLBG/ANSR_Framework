<?php
namespace ANSR\Driver;

class PDODatabase implements DatabaseInterface
{
    private $pdo;

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

