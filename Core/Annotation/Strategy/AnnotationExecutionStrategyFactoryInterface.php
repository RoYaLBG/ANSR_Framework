<?php

namespace ANSR\Core\Annotation\Strategy;


use ANSR\Core\Annotation\AnnotationInterface;

interface AnnotationExecutionStrategyFactoryInterface
{
    public function create(string $name, AnnotationInterface $annotation): AnnotationExecutionStrategyInterface;
}