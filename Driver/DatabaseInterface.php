<?php

namespace ANSR\Driver;

interface DatabaseInterface
{
    public function prepare($query): DatabaseStatementInterface;

    public function lastId($name = null);
}


