<?php
/**
 * Created by IntelliJ IDEA.
 * User: RoYaL
 * Date: 12/22/2016
 * Time: 7:00 PM
 */

namespace ANSR\Core\Annotation\Strategy;


interface AnnotationExecutionStrategyInterface
{
    const STRATEGY_SUFFIX = 'ExecutionStrategy';

    public function execute();
}