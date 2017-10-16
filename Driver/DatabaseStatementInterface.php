<?php

namespace ANSR\Driver;

interface DatabaseStatementInterface
{
    public function fetchAll();

    public function fetchRow();

    public function fetchObject($className);

    public function execute(array $args = []): bool;
}

