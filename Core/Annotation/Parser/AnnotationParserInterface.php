<?php

namespace ANSR\Core\Annotation\Parser;


use ANSR\Core\Annotation\AnnotationInterface;

interface AnnotationParserInterface
{
    /**
     * @param \ReflectionClass|\ReflectionMethod $target
     * @return AnnotationInterface[]
     */
    public function parse($target);
}