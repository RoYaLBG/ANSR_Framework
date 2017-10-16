<?php

namespace ANSR\Core\Annotation\Strategy;


interface AnnotationExecutionStrategyInterface
{
    const STRATEGY_SUFFIX = 'ExecutionStrategy';

    public function execute();
}