<?php

namespace ANSR\Core\Data;


use ANSR\Core\Data\Mapping\TableLocatorInterface;
use ANSR\Core\Data\Query\QueryBuilderInterface;

use ANSR\Core\Annotation\Type\Component;


/**
 * @Component
 */
class EntityManager implements EntityManagerInterface
{
    /**
     * @var TableLocatorInterface
     */
    private $tableLocator;

    /**
     * @var QueryBuilderInterface
     */
    private $queryBuilder;

    public function __construct(TableLocatorInterface $tableLocator,
                                QueryBuilderInterface $queryBuilder)
    {
        $this->tableLocator = $tableLocator;
        $this->queryBuilder = $queryBuilder;
    }


    public function persist($object): void
    {
        $table = $this->tableLocator->locateName(get_class($object));
        $id = $this->tableLocator->locatePrimaryKey(get_class($object));
        $idGetter = 'get' . ucfirst($id);
        $result = $this->queryBuilder->select()
            ->from($table)
            ->where([$id => $object->$idGetter()])
            ->build();
        if (!$result->fetchObject(get_class($object))) {
            $this->doInsert($object, $table);
        } else {
            $this->doUpdate($object, $table, [$id => $object->$idGetter()]);
        }
    }

    private function doInsert($object, string $table)
    {
        $values = $this->getValues($object);

        $this->queryBuilder->insert($table, $values);
    }

    private function doUpdate($object, string $table, array $where)
    {
        $values = $this->getValues($object);

        $this->queryBuilder->update($table, $values, $where);
    }

    private function getValues($object): array
    {
        $values = [];

        foreach ((new \ReflectionClass($object))->getProperties() as $property) {
            $property->setAccessible(true);
            $name = $property->getName();
            $value = $property->getValue($object);
            $values[$name] = $value;
        }
        return $values;
    }
}