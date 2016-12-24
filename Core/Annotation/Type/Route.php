<?php
namespace ANSR\Core\Annotation\Type;


use ANSR\Core\Annotation\AnnotationAbstract;

class Route extends AnnotationAbstract
{
    private $method = 'GET';

    private $name = "";

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method)
    {
        $this->method = $method;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }
}