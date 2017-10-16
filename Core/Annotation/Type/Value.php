<?php

namespace ANSR\Core\Annotation\Type;


use ANSR\Core\Annotation\AnnotationAbstract;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class Value extends AnnotationAbstract
{
    private $param = "";

    public function getParam(): string
    {
        return $this->param;
    }

    public function setParam(string $param)
    {
        $this->param = $param;
    }


}