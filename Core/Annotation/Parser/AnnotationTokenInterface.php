<?php
namespace ANSR\Core\Annotation\Parser;


use ANSR\Core\Annotation\Builder\AnnotationBuilderInterface;

interface AnnotationTokenInterface
{
    const CONSTRUCTOR_VALUE = 'value';

    public function getProperty($property);

    /**
     * @param \ReflectionClass|\ReflectionMethod $annotatedObject
     * @return AnnotationBuilderInterface
     */
    public function getBuilder($annotatedObject): AnnotationBuilderInterface;

    public function getProperties(): array;
}