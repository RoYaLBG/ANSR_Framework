<?php

namespace ANSR\Core\Annotation;


interface AnnotationInterface
{
    const KEYWORD_CLASS = 'class';
    const KEYWORD_METHOD = 'method';

    public function getValue();

    public function setAnnotatedObject($annotatedObject);

    /**
     * @return \ReflectionClass
     */
    public function getAnnotatedClass();

    /**
     * @return \ReflectionMethod
     */
    public function getAnnotatedMethod();
}