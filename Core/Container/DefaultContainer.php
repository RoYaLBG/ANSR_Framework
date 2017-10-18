<?php

namespace ANSR\Core\Container;


use ANSR\Config\Variables;
use ANSR\Core\Annotation\Strategy\ComponentExecutionStrategy;
use ANSR\Core\Annotation\Strategy\ValueExecutionStrategy;


/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class DefaultContainer implements ContainerInterface
{
    /**
     * @var string[]
     */
    private $dependencies = [];

    /**
     * @var object[]
     */
    private $resolvedDependencies = [];

    /**
     * @var string[]
     */
    private $values = [];

    public function registerDependency(string $abstraction, string $implementation)
    {
        $this->dependencies[$abstraction] = $implementation;
    }

    public function addBean(string $abstraction, $object)
    {
        $this->dependencies[$abstraction] = get_class($object);
        $this->resolvedDependencies[get_class($object)] = $object;
        $this->resolvedDependencies[$abstraction] = $object;
    }

    public function resolve($className, $interfaceName = null)
    {
        if (array_key_exists($className, $this->resolvedDependencies)) {
            return $this->resolvedDependencies[$className];
        }

        $refClass = new \ReflectionClass($className);
        if ($refClass->isInterface()) {
            $interfaceName = $className;
            $className = $this->dependencies[$interfaceName];
            if (array_key_exists($className, $this->resolvedDependencies)) {
                return $this->resolvedDependencies[$className];
            }
            $refClass = new \ReflectionClass($className);
        }

        $constructor = $refClass->getConstructor();

        if ($constructor === null) {
            $object = new $className;

            $this->resolvedDependencies[$className] = $object;

            return $object;
        }

        $parameters = $constructor->getParameters();

        $arguments = [];
        $dependentValues = isset($this->values[$refClass->getName()])
            ? $this->values[$refClass->getName()]
            : [];
        foreach ($parameters as $parameter) {
            if (array_key_exists($parameter->getName(), $dependentValues)) {
                $arguments[] = Variables::$args[$dependentValues[$parameter->getName()]];
            } else {
                $dependencyInterface = $parameter->getClass();
                $dependencyClass = $this->dependencies[$dependencyInterface->getName()];
                $arguments[] = $this->resolve($dependencyClass, $dependencyInterface->getName());
            }
        }

        $object = $refClass->newInstanceArgs($arguments);
        if ($interfaceName == null) {
            $interfaceName = $className;
        }
        $this->addBean($interfaceName, $object);

        return $object;
    }

    public function getDependency($abstraction)
    {
        return $this->dependencies[$abstraction];
    }

    public function exists($abstraction): bool
    {
        return array_key_exists($abstraction, $this->dependencies);
    }

    public function initialLoad(string $path)
    {
        $loadedDependencies = include $path . DIRECTORY_SEPARATOR . ComponentExecutionStrategy::CACHE_FILE;
        foreach ($loadedDependencies as $abstraction => $implementations) {
            $highestPriority = max(array_keys($implementations));
            $this->registerDependency($abstraction, $implementations[$highestPriority]);
            foreach ($implementations as $implementation) {
                $this->registerDependency($implementation, $implementation);
            }
        }

        $loadedValues = include $path . DIRECTORY_SEPARATOR . ValueExecutionStrategy::CACHE_FILE;
        foreach ($loadedValues as $implementation => $values) {
            $this->values[$implementation] = $values;
        }
    }
}