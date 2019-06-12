<?php

namespace ANSR\Core\Data\Query;


use ANSR\Driver\DatabaseStatementInterface;

interface QueryBuilderInterface
{
    public function insert(string $table, array $values): DatabaseStatementInterface;

    public function update(string $table, array $values, array $where): DatabaseStatementInterface;

    public function select(array $columns = []): QueryBuilderInterface;

    public function from(string $table): QueryBuilderInterface;

    public function join(string $table, bool $optional = false): QueryBuilderInterface;

    public function on(array $criteria): QueryBuilderInterface;

    public function where(array $criteria): QueryBuilderInterface;

    public function groupBy(array $columns): QueryBuilderInterface;

    public function orderBy(array $criteria): QueryBuilderInterface;

    public function average(string $column): string;

    public function sum(string $column): string;

    public function max(string $column): string;

    public function min(string $column): string;

    public function build(): DatabaseStatementInterface;
}