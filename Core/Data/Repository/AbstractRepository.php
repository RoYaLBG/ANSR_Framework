<?php

namespace ANSR\Core\Data\Repository;

use ANSR\Core\Data\Mapping\TableLocatorInterface;
use ANSR\Core\Data\Query\QueryBuilderInterface;

class AbstractRepository implements RepositoryInterface
{
    /**
     * @var string
     */
    private $table;

    /**
     * @var string
     */
    private $entity;

    /**
     * @var string
     */
    private $primaryKeyName;

    /**
     * @var QueryBuilderInterface
     */
    private $queryBuilder;

    /**
     * @var TableLocatorInterface
     */
    private $tableLocator;

    public function __construct(string $entity,
                                QueryBuilderInterface $queryBuilder,
                                TableLocatorInterface $tableLocator)
    {
        $this->table = $tableLocator->locateName($entity);
        $this->entity = $entity;
        $this->primaryKeyName = $tableLocator->locatePrimaryKey($entity);
        $this->queryBuilder = $queryBuilder;
        $this->tableLocator = $tableLocator;
    }


    public function findAll(array $orderBy = []): \Generator
    {
        $builder = $this->queryBuilder->select()
            ->from($this->table);

        if (!empty($orderBy)) {
            $builder = $builder->orderBy($orderBy);
        }

        $stmt = $builder->build();

        while ($row = $stmt->fetchObject($this->entity)) {
            yield $row;
        }
    }

    public function findOne($id): ?object
    {
        $stmt = $this->queryBuilder->select()
            ->from($this->table)
            ->where([$this->primaryKeyName => $id])
            ->build();

        return $stmt->fetchObject($this->entity);
    }

    public function findBy(array $criteria, array $orderBy = []): \Generator
    {
        $builder = $this->queryBuilder->select()
            ->from($this->table)
            ->where($criteria);

        if (!empty($orderBy)) {
            $builder = $builder->orderBy($orderBy);
        }

        $stmt = $builder->build();

        while ($row = $stmt->fetchObject($this->entity)) {
            yield $row;
        }
    }

    public function findOneBy(array $criteria, array $orderBy = []): ?object
    {
        foreach ($this->findBy($criteria, $orderBy) as $res) {
            return $res;
        }

        return null;
    }
}