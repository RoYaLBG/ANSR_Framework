<?php

namespace ANSR\Core\Annotation\Builder;


use ANSR\Core\Annotation\AnnotatedFileInfo;
use ANSR\Core\Annotation\AnnotationInterface;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class DefaultAnnotationBuilder implements AnnotationBuilderInterface
{
    /**
     * @var AnnotationInterface
     */
    private $instance;

    /**
     * @var \ReflectionClass|\ReflectionMethod
     */
    private $annotationObject;

    public function __construct(AnnotationInterface $instance, $annotationObject)
    {
        $this->instance = $instance;
        $this->annotationObject = $annotationObject;
    }


    public function setProperty($property, $value): AnnotationBuilderInterface
    {
        $method = 'set' . ucfirst($property);
        if (method_exists($this->instance, $method)) {
            $this->instance->$method($value);

            return $this;
        }

        $refClass = new \ReflectionClass($this->instance);
        $refProperty = $refClass->getProperty($property);
        $refProperty->setAccessible(true);
        $refProperty->setValue($this->instance, $value);

        return $this;
    }

    public function build(): AnnotationInterface
    {
        if ($this->annotationObject instanceof \ReflectionMethod) {
            $annotationInfo = [
                AnnotationInterface::KEYWORD_CLASS => $this->annotationObject->getDeclaringClass(),
                AnnotationInterface::KEYWORD_METHOD => $this->annotationObject
            ];
        } else {
            $annotationInfo = [
                AnnotationInterface::KEYWORD_CLASS => $this->annotationObject,
                AnnotationInterface::KEYWORD_METHOD => null
            ];
        }

        $this->instance->setAnnotatedObject($annotationInfo);

        return $this->instance;
    }

    public function setAnnotedFileInfo(AnnotatedFileInfo $annotatedFileInfo): AnnotationBuilderInterface
    {
        $this->instance->setAnnotatedFileInfo($annotatedFileInfo);

        return $this;
    }
}