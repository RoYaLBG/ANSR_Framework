<?php

namespace ANSR\Core\Data\Repository;


interface RepositoryInterface
{
    public function findAll(array $orderBy = []): \Generator;

    public function findOne($id): ?object;

    public function findBy(array $criteria, array $orderBy = []): \Generator;

    public function findOneBy(array $criteria, array $orderBy = []): ?object;
}