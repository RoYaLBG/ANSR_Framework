<?php

namespace ANSR\Core\Data\Repository;


use ANSR\Core\Data\Entity\User;
use ANSR\Core\Data\Mapping\TableLocatorInterface;
use ANSR\Core\Data\Query\QueryBuilderInterface;

class UserRepository extends AbstractRepository
{
    public function __construct(QueryBuilderInterface $queryBuilder,
                                TableLocatorInterface $tableLocator)
    {
        parent::__construct(User::class, $queryBuilder, $tableLocator);
    }
}