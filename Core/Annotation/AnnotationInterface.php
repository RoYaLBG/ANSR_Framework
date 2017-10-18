<?php

namespace ANSR\Core\Annotation;


interface AnnotationInterface
{
    const KEYWORD_CLASS = 'class';
    const KEYWORD_METHOD = 'method';

    public function getValue();

    public function setAnnotatedObject($annotatedObject);

    public function setAnnotatedFileInfo(AnnotatedFileInfo $annotatedFileInfo);

    public function getFileInfo(): AnnotatedFileInfo;

    /**
     * @return \ReflectionClass
     */
    public function getAnnotatedClass();

    /**
     * @return \ReflectionMethod
     */
    public function getAnnotatedMethod();
}