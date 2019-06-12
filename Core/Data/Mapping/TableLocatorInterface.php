<?php

namespace ANSR\Core\Data\Mapping;

interface TableLocatorInterface
{
    public function locateName(string $entityPath): string;

    public function locatePrimaryKey(string $entityPath): string;
}