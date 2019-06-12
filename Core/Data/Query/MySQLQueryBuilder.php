<?php

namespace ANSR\Core\Data\Query;


use ANSR\Driver\DatabaseInterface;
use ANSR\Driver\DatabaseStatementInterface;

class MySQLQueryBuilder implements QueryBuilderInterface
{
    private $query;

    private $db;

    private $whereCriteria;

    private $lastJoinedTable;

    private $from;

    public function __construct(DatabaseInterface $db)
    {
        $this->query = '';
        $this->db = $db;
        $this->whereCriteria = [];
    }

    public function select(array $columns = []): QueryBuilderInterface
    {
        $this->query .= "SELECT ";
        if (empty($columns)) {
            $this->query .= '*';
        } else {
            foreach ($columns as $columnIdentifier => $aliasCandidate) {
                $alias = $aliasCandidate;
                if (is_int($columnIdentifier)) {
                    $columnName = $aliasCandidate;
                } else {
                    $columnName = $columnIdentifier;
                }

                $this->query .= $columnName . ' AS ' . $alias . ', ';
            }
        }

        $this->query = rtrim($this->query, ', ');

        return $this;
    }

    public function from(string $table): QueryBuilderInterface
    {
        $this->query .= " FROM " . $table;
        $this->from = $table;

        return $this;
    }

    public function where(array $criteria): QueryBuilderInterface
    {
        $this->query .= " WHERE 1=1";
        foreach (array_keys($criteria) as $column) {
            $this->query .= " AND " . $column . " = ?";
        }

        $this->whereCriteria = array_values($criteria);

        return $this;
    }

    public function groupBy(array $columns): QueryBuilderInterface
    {
        $this->query .= " GROUP BY " . implode(', ', $columns);

        return $this;
    }

    public function orderBy(array $criteria): QueryBuilderInterface
    {
        $this->query .= " ORDER BY ";
        foreach ($criteria as $column => $modifier) {
            $this->query .= $column . ' ' . $modifier . ', ';
        }

        $this->query = rtrim($this->query, ', ');

        return $this;
    }

    public function average(string $column): string
    {
        return "AVG(" . $column . ")";
    }

    public function sum(string $column): string
    {
        return "SUM(" . $column . ")";
    }

    public function max(string $column): string
    {
        return "MAX(" . $column . ")";
    }

    public function min(string $column): string
    {
        return "MIN(" . $column . ")";
    }

    public function build(): DatabaseStatementInterface
    {
        $stmt = $this->db->prepare($this->query);
        $stmt->execute($this->whereCriteria);

        return $stmt;
    }

    public function join(string $table, bool $optional = false): QueryBuilderInterface
    {
        if ($optional) {
            $this->query .= " LEFT";
        } else {
            $this->query .= " INNER";
        }

        $this->query .= " JOIN " . $table;

        $this->lastJoinedTable = $table;

        return $this;
    }

    public function on(array $criteria): QueryBuilderInterface
    {
        $this->query .= " ON 1=1 ";
        foreach ($criteria as $ourColumn => $theirColumn) {
            $this->query .= "AND " . $this->from . "." . $ourColumn . " = " . $this->lastJoinedTable . "." . $theirColumn;
        }

        return $this;
    }

    public function insert(string $table, array $values): DatabaseStatementInterface
    {
        $query = "INSERT INTO " . $table . "(" . implode(', ', array_keys($values)) .  ")" . " VALUES ( " . implode(', ', array_fill(0, count($values), '?')) . ")";
        $stmt = $this->db->prepare($query);
        $stmt->execute(array_values($values));

        return $stmt;
    }

    public function update(string $table, array $values, array $where): DatabaseStatementInterface
    {
        $query = "UPDATE " . $table . " SET ";
        foreach (array_keys($values) as $column) {
            $query .= $column . " = ?, ";
        }

        $query = rtrim($query, ', ');

        $query .= " WHERE 1=1";
        foreach (array_keys($where) as $column) {
            $query .= " AND " . $column . " = ?";
        }

        $stmt = $this->db->prepare($query);
        $stmt->execute(array_merge(array_values($values), array_values($where)));

        return $stmt;
    }
}