<?php

namespace ANSR\Core\Annotation\Strategy;


use ANSR\Core\Annotation\AnnotationInterface;
use ANSR\Core\Container\ContainerInterface;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
abstract class ContainerAwareExecutionStrategy implements AnnotationExecutionStrategyInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var AnnotationInterface
     */
    protected $annotation;

    public function __construct(ContainerInterface $container,
                                AnnotationInterface $instance)
    {
        $this->container = $container;
        $this->annotation = $instance;
    }


    public abstract function execute();

}