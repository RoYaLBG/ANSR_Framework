<?php

namespace ANSR\Core\Annotation\Strategy;


use ANSR\Core\Annotation\Type\ResponseExclude;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class ResponseExcludeExecutionStrategy extends ContainerAwareExecutionStrategy
{
    /**
     * @var ResponseExclude
     */
    protected $annotation;

    public function execute()
    {

    }
}