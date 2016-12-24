<?php

namespace ANSR\Core\Annotation\Strategy;


use ANSR\Core\Annotation\AnnotationInterface;
use ANSR\Core\Container\ContainerInterface;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class AnnotationExecutionStrategyFactory implements AnnotationExecutionStrategyFactoryInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    public function create(string $name,
                           AnnotationInterface $annotation) : AnnotationExecutionStrategyInterface
    {
        $suffix = AnnotationExecutionStrategyInterface::STRATEGY_SUFFIX;
        $strategyName = __NAMESPACE__ . '\\' . $name . $suffix;

        return new $strategyName($this->container, $annotation);
    }
}