<?php

namespace ANSR\Core\Annotation;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
abstract class AnnotationAbstract implements AnnotationInterface
{
    protected $value;

    /**
     * @var AnnotatedFileInfo
     */
    protected $fileInfo;

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

    public function setAnnotatedFileInfo(AnnotatedFileInfo $annotatedFileInfo)
    {
        $this->fileInfo = $annotatedFileInfo;
    }

    public function getFileInfo(): AnnotatedFileInfo
    {
        return $this->fileInfo;
    }
}