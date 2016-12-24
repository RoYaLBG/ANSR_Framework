<?php

namespace ANSR\Core\Annotation;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class AnnotationAbstract implements AnnotationInterface
{
    protected $value;

    private $annotatedObject;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setAnnotatedObject($annotatedObject)
    {
        $this->annotatedObject = $annotatedObject;
    }

    public function getAnnotatedClass()
    {
        return $this->annotatedObject[self::KEYWORD_CLASS];
    }

    public function getAnnotatedMethod()
    {
        return $this->annotatedObject[self::KEYWORD_METHOD];
    }
}