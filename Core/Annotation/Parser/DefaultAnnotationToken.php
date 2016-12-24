<?php

namespace ANSR\Core\Annotation\Parser;

use ANSR\Core\Annotation\Builder\AnnotationBuilderInterface;
use ANSR\Core\Annotation\Builder\DefaultAnnotationBuilder;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class DefaultAnnotationToken implements AnnotationTokenInterface
{
    private $className;

    private $properties;

    public function __construct($className, $properties)
    {
        $this->className = $className;
        $this->properties = $properties;
    }

    public function getProperty($property)
    {
        return $this->properties[$property];
    }

    public function getProperties(): array
    {
        return $this->properties;
    }

    public function getBuilder($annotatedObject): AnnotationBuilderInterface
    {
        if (!class_exists($this->className)) {
            throw new \Exception("Invalid annotation");
        }

        $className = $this->className;
        if (array_key_exists(self::CONSTRUCTOR_VALUE, $this->properties)) {
            $instance = new $className($this->properties[self::CONSTRUCTOR_VALUE]);
        } else {
            $instance = new $className();
        }

        return new DefaultAnnotationBuilder($instance, $annotatedObject);
    }
}