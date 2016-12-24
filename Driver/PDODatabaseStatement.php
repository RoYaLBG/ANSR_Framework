<?php
namespace ANSR\Driver;

class PDODatabaseStatement implements DatabaseStatementInterface
{
    private $statement;

    public function __construct(\PDOStatement $statement)
    {
        $this->statement = $statement;
    }

    public function fetchAll()
    {
        while ($row = $this->fetchRow()) {
            yield $row;
        }
    }

    public function fetchRow()
    {
        return $this->statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function execute(array $args = []): bool
    {
        return $this->statement->execute($args);
    }

    public function fetchObject($className)
    {
        return $this->statement->fetchObject($className);
    }
}


